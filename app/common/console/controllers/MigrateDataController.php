<?php
namespace common\console\controllers;

use common\models\Age;
use common\models\FunctionalCluster;
use common\models\Gene;
use common\models\GeneExpressionInSample;
use common\models\GeneToFunctionalCluster;
use common\models\Sample;
use common\models\User;
use yii\console\Controller;

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
        foreach($arGenes as $arGene) {
            echo $arGene->symbol . ': ';
            $expression = json_decode($arGene->expressionEN, true);
            $expressionRu = json_decode($arGene->expression, true);
            if($expression) {
                $geneSamplesNamesEn = array_keys($expression);
                $geneSamplesNamesRu = array_keys($expressionRu);
                $samplesNames = array_merge($samplesNames, array_combine($geneSamplesNamesEn, $geneSamplesNamesRu));
                foreach($expression as $sample => $expressionValues) {
                    echo $sample . ' ';
                    $arSample = Sample::find()
                        ->andWhere(['name_en' => $sample])
                        ->one();
                    if(!$arSample) {
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
                    if(!$arGeneExpressionSample) {
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
        foreach($arGenes as $arGene) {
            echo $arGene->symbol . ': ';
            $functionalClustersRu = explode(',', $arGene->functionalClusters);
            if($functionalClustersRu) {
                foreach ($functionalClustersRu as $functionalClusterRu) {
                    $functionalClusterRu = trim($functionalClusterRu);
                    $arFunctionalCluster = FunctionalCluster::find()
                        ->where(['name_ru' => $functionalClusterRu])
                        ->one();
                    if(!$arFunctionalCluster) {
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
                    if(!$arGeneToFunctionalCluster) {
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
        foreach($arGenes as $arGene) {
            echo $arGene->symbol . ': ';
            if($arGene->agePhylo) {
                if ($arGene->agePhylo == 'Procaryota') {
                    $arGene->agePhylo = 'Prokaryota';
                }
                $arAge = Age::find()->where(
                    ['name_phylo' => $arGene->agePhylo]
                )->one();
            } elseif ($arGene->ageMya) {
                $arAge = $arAge = Age::find()->where(
                    ['name_mya' => $arGene->ageMya]
                );
            }
            if(isset($arAge) && $arAge instanceof Age) {
                $arGene->age_id = $arAge->id;
                $arGene->save();
                echo $arAge->name_phylo . PHP_EOL;
            } else {
                echo 'no age info' . PHP_EOL;
            }
        }
    }

}
