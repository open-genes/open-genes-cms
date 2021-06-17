<?php
namespace app\console\controllers;

use app\models\CommentCause;
use app\models\Phylum;
use app\models\FunctionalCluster;
use app\models\Gene;
use app\models\common\GeneExpressionInSample;
use app\models\GeneToCommentCause;
use app\models\GeneToFunctionalCluster;
use app\models\common\GeneToProteinClass;
use app\models\ProteinClass;
use app\models\Sample;
use yii\console\Controller;
use yii\httpclient\Client;

class MigrateDataController extends Controller
{
    public function behaviors()
    {
        return parent::behaviors();
    }

    public function actionMigrateExpression()
    {
        $samplesNames = [];
        $arGenes = Gene::find()->all();
        foreach ($arGenes as $arGene) {
            echo $arGene->symbol . ': ';
            $expression = json_decode($arGene->expressionEN, true);
            $expressionRu = json_decode($arGene->expression, true);
            if ($expression) {
                $geneSamplesNamesEn = array_keys($expression);
                $geneSamplesNamesRu = array_keys($expressionRu);
                $samplesNames = array_merge($samplesNames, array_combine($geneSamplesNamesEn, $geneSamplesNamesRu));
                foreach ($expression as $sample => $expressionValues) {
                    echo $sample . ' ';
                    $arSample = Sample::find()
                        ->andWhere(['name_en' => $sample])
                        ->one();
                    if (!$arSample) {
                        $arSample = new Sample();
                        $arSample->name_en = $sample;
                        $arSample->name_ru = $samplesNames[$sample];
                        $arSample->save();
                        $arSample->refresh();
                    }
                    $arGeneExpressionSample = GeneExpressionInSample::find()
                        ->andWhere(['gene_id' => $arGene->id])
                        ->andWhere(['sample_id' => $arSample->id])
                        ->one();
                    if (!$arGeneExpressionSample) {
                        $arGeneExpressionSample = new GeneExpressionInSample();
                        $arGeneExpressionSample->gene_id = $arGene->id;
                        $arGeneExpressionSample->sample_id = $arSample->id;
                    }
                    $arGeneExpressionSample->expression_value = $expressionValues['full_rpkm'];
                    $arGeneExpressionSample->save();
                }
            } else {
                echo 'No expression for gene ' . $arGene->id;
            }
            echo PHP_EOL;
        }
    }

    public function actionMigrateFunctionalClusters()
    {
        $arGenes = Gene::find()->all();
        foreach ($arGenes as $arGene) {
            echo $arGene->symbol . ': ';
            $functionalClustersRu = explode(',', $arGene->functionalClusters);
            if ($functionalClustersRu) {
                foreach ($functionalClustersRu as $functionalClusterRu) {
                    $functionalClusterRu = trim($functionalClusterRu);
                    $arFunctionalCluster = FunctionalCluster::find()
                        ->where(['name_ru' => $functionalClusterRu])
                        ->one();
                    if (!$arFunctionalCluster) {
                        $arFunctionalCluster = new FunctionalCluster();
                        $arFunctionalCluster->name_ru = $functionalClusterRu;
                        $arFunctionalCluster->name_en = \Yii::t('main', str_replace([' ', '/'], '_', $functionalClusterRu), [], 'en-US');
                        $arFunctionalCluster->save();
                        $arFunctionalCluster->refresh();
                    }
                    $arGeneToFunctionalCluster = GeneToFunctionalCluster::find()
                        ->andWhere(['gene_id' => $arGene->id])
                        ->andWhere(['functional_cluster_id' => $arFunctionalCluster->id])
                        ->one();
                    if (!$arGeneToFunctionalCluster) {
                        $arGeneToFunctionalCluster = new GeneToFunctionalCluster();
                        $arGeneToFunctionalCluster->gene_id = $arGene->id;
                        $arGeneToFunctionalCluster->functional_cluster_id = $arFunctionalCluster->id;
                    }
                    $arGeneToFunctionalCluster->save();
                    echo $arFunctionalCluster->name_ru . ' ';
                }
                echo PHP_EOL;
            }
        }
    }

    public function actionMigrateAge()
    {
        $arGenes = Gene::find()->all();
        foreach ($arGenes as $arGene) {
            echo $arGene->symbol . ': ';
            if ($arGene->agePhylo) {
                if ($arGene->agePhylo == 'Procaryota') {
                    $arGene->agePhylo = 'Prokaryota';
                }
                $arAge = Phylum::find()->where(
                    ['name_phylo' => $arGene->agePhylo]
                )->one();
            } elseif ($arGene->ageMya) {
                $arAge = $arAge = Phylum::find()->where(
                    ['name_mya' => $arGene->ageMya]
                );
            }
            if (isset($arAge) && $arAge instanceof Phylum) {
                $arGene->age_id = $arAge->id;
                $arGene->save();
                echo $arAge->name_phylo . PHP_EOL;
            } else {
                echo 'no age info' . PHP_EOL;
            }
        }
    }

    public function actionMigrateCommentCause()
    {
        $arGenes = Gene::find()->all();
        foreach ($arGenes as $arGene) {
            echo $arGene->symbol . ': ';
            $commentCausesRu = explode(',', $arGene->commentCause);
            if ($commentCausesRu) {
                foreach ($commentCausesRu as $commentCauseRu) {
                    $commentCauseRu = trim($commentCauseRu);
                    $arCommentCause = CommentCause::find()
                        ->where(['name_ru' => $commentCauseRu])
                        ->one();
                    if (!$arCommentCause) {
                        $arCommentCause = new CommentCause();
                        $arCommentCause->name_ru = $commentCauseRu;
                        $nameForTranslate = str_replace([' ', '/'], '_', mb_strtolower($commentCauseRu));
                        $arCommentCause->name_en = \Yii::t('main', $nameForTranslate, [], 'en-US');
                        $arCommentCause->save();
                        $arCommentCause->refresh();
                    }
                    $arGeneToCommentCause = GeneToCommentCause::find()
                        ->andWhere(['gene_id' => $arGene->id])
                        ->andWhere(['comment_cause_id' => $arCommentCause->id])
                        ->one();
                    if (!$arGeneToCommentCause) {
                        $arGeneToCommentCause = new GeneToCommentCause();
                        $arGeneToCommentCause->gene_id = $arGene->id;
                        $arGeneToCommentCause->comment_cause_id = $arCommentCause->id;
                    }
                    $arGeneToCommentCause->save();
                    echo $arCommentCause->name_ru . ' ';
                }
                echo PHP_EOL;
            }
        }
    }

}
