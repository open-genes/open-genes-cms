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
        $geneArray = Gene::find()
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
        $genesArray = Gene::find()
            ->select('*')
            ->where(['in', 'symbol', ['CISD2', 'EMD', 'ADCY5', 'AGTR1']]) // todo хардкод, пока нет реальных изменяемых данных
            ->orderBy('updated_at desc') // todo
            ->limit($count)
            ->asArray()
            ->all();
        return $genesArray;
    }

    public function getAllGenes(int $count = null): array // todo чем запрос всех генов будет отличаться от виджета последних?
    {
        $genesArrayQuery = Gene::find()
            ->select('*')
            ->andWhere('commentEvolution != ""')
            ->andWhere('isHidden != 1')
            ->orderBy('ageMya DESC')
            ->limit($count)
            ->asArray();
         if($count) {
             $genesArrayQuery->limit($count);
         }
        $genesArray = $genesArrayQuery->all();
        return $genesArray;
    }
}