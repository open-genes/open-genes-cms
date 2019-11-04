<?php
namespace genes\infrastructure\dataProvider;

use common\models\Gene;
use common\models\GeneQuery;
use yii\web\NotFoundHttpException;

class GeneDataProvider implements GeneDataProviderInterface
{
    /** @inheritDoc */
    public function getGene($geneId): array
    {
        $geneArray = (new GeneQuery(Gene::class))
            ->select('*')
            ->where(['ID' => $geneId])
            ->asArray()
            ->one();
        if(!$geneArray) {
            throw new NotFoundHttpException("Gene {$geneId} not found");
        }
        return $geneArray;
    }

    public function getLatestGenes(int $count): array
    {
        $genesArray = (new GeneQuery(Gene::class))
            ->select('*')
            ->orderBy('functionalClusters desc') // todo
            ->limit($count)
            ->asArray()
            ->all();
        return $genesArray;
    }

    public function getAllGenes(int $count = null): array // todo чем запрос всех генов будет отличаться от виджета последних?
    {
        $genesArrayQuery = (new GeneQuery(Gene::class))
            ->select('*')
            ->orderBy('functionalClusters desc') // todo
            ->limit($count)
            ->asArray();
         if($count) {
             $genesArrayQuery->limit($count);
         }
        $genesArray = $genesArrayQuery->all();
        return $genesArray;
    }
}