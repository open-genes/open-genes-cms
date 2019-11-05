<?php
namespace common\console\controllers;

use common\models\GeneExpressionInSample;
use common\models\Sample;
use common\models\User;
use genes\models\Gene;
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

}
