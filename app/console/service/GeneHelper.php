<?php

namespace app\console\service;

use app\models\common\GeneToSource;
use app\models\Gene;
use app\models\Source;

class GeneHelper
{
    public static function getUnaddedGeneToFileBySymbol($symbol, $sourceId) {
        $symbol = strtoupper(trim($symbol));
        $arGene = Gene::find()->where(['symbol' => $symbol])->one();
        if ($arGene) {
            echo 'gene found' . PHP_EOL;
        } else {
            /** @var ParseMyGeneServiceInterface $myGeneService */
            $myGeneService = \Yii::$container->get(ParseMyGeneServiceInterface::class);
            $arGene = $myGeneService->parseBySymbolAndAddToFile($symbol);
            if (!empty($arGene) && !$arGene->symbol) {
                return $arGene;
            }
            $symbolExists = Gene::findOne(['symbol' => $arGene->symbol]);
            if($symbolExists) {
                echo 'gene found' . PHP_EOL;
                return;
            }
            $arGene->isHidden = 1;
            $arGene->save();

            $geneToSource = new GeneToSource();
            $geneToSource->gene_id = $arGene->id;
            $geneToSource->source_id = $sourceId;
            $geneToSource->save();

            echo 'OK ' . $symbol . ' ' . $arGene->ncbi_id . PHP_EOL;
        }
        return;
    }

    public static function saveGeneBySymbol($symbol, $sourceId) {
        $symbol = strtoupper(trim($symbol));
        $arGene = Gene::find()->where(['symbol' => $symbol])->one();
        if ($arGene) {
            echo 'gene found' . PHP_EOL;
        } else {
            /** @var ParseMyGeneServiceInterface $myGeneService */
            $myGeneService = \Yii::$container->get(ParseMyGeneServiceInterface::class);
            $arGene = $myGeneService->parseBySymbol($symbol);
            if (!$arGene) {
                return;
            }
            $symbolExists = Gene::findOne(['symbol' => $arGene->symbol]);
            if($symbolExists) {
                echo 'gene found' . PHP_EOL;
                return;
            }
            $arGene->isHidden = 1;
            $arGene->save();

            $geneToSource = new GeneToSource();
            $geneToSource->gene_id = $arGene->id;
            $geneToSource->source_id = $sourceId;
            $geneToSource->save();

            echo 'OK ' . $symbol . ' ' . $arGene->ncbi_id . PHP_EOL;
        }
        return $arGene->id;
    }
}