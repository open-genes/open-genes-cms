<?php

namespace app\console\service;

use app\models\common\GeneToSource;
use app\models\Gene;

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
            $arGene->isHidden = 1;
            $arGene->save();

            $geneToSource = new GeneToSource();
            $geneToSource->gene_id = $arGene->id;
            $geneToSource->source_id = $source;

            echo 'OK ' . $symbol . ' ' . $arGene->ncbi_id . PHP_EOL;
        }
        return $arGene->id;
    }
}