<?php

namespace app\console\service;

use app\models\common\GeneToSource;
use app\models\Gene;
use app\models\Source;

class GeneHelper
{
    public static function saveGeneBySymbol($symbol, $source) {
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
            $newGeneId = Gene::findOne(['symbol' => $arGene->symbol])->id;

            $geneToSource = new GeneToSource();
            $geneToSource->gene_id = $newGeneId;
            $geneToSource->source_id = $source;
            $geneToSource->save();

            echo 'OK ' . $symbol . ' ' . $arGene->ncbi_id . PHP_EOL;
        }
        return $arGene->id;
    }
}