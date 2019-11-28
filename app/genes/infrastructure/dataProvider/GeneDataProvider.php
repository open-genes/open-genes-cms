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
            ->select('gene.*')
            ->withFunctionalClustersConcat()
            ->where(['gene.id' => $geneId])
            ->withAge()
            ->asArray()
            ->groupBy('gene.id')
            ->one();
        if(!$geneArray) {
            throw new NotFoundHttpException("Gene {$geneId} not found");
        }
        return $geneArray;
    }

    /** @inheritDoc */
    public function getLatestGenes(int $count): array
    {
        $genesArray = Gene::find()
            ->select('*')
            ->where(['in', 'symbol', ['CISD2', 'EMD', 'ADCY5', 'AGTR1']]) // todo хардкод, пока нет реальных изменяемых данных
            ->withAge()
            ->orderBy('gene.updated_at desc')
            ->limit($count)
            ->asArray()
            ->all();
        return $genesArray;
    }

    /** @inheritDoc */
    public function getAllGenes(int $count = null): array
    {
        $genesArrayQuery = Gene::find()
            ->select('gene.*')
            ->withAge()
            ->withFunctionalClustersConcat()
            ->andWhere('commentEvolution != ""')
            ->andWhere('isHidden != 1')
            ->orderBy('ageMya DESC')
            ->limit($count)
            ->groupBy('gene.id')
            ->asArray();
         if($count) {
             $genesArrayQuery->limit($count);
         }
        $genesArray = $genesArrayQuery->all();
        return $genesArray;
    }

    /** @inheritDoc */
    public function getByFunctionalClustersIds(array $functionalClustersIds): array
    {
        $genesArrayQuery = Gene::find()
            ->select('gene.*')
            ->withAge()
            ->withFunctionalClustersConcat()

            ->andWhere('commentEvolution != ""')
            ->andWhere('isHidden != 1')
            ->orderBy('ageMya DESC')
            ->groupBy('gene.id')
            ->asArray();
        $joinCounter = 0;
        foreach($functionalClustersIds as $functionalClustersId) {
            $genesArrayQuery->innerJoin(
                "gene_to_functional_cluster filter_cluster_{$joinCounter}",
                ['and', "filter_cluster_{$joinCounter}.gene_id = gene.id", ["filter_cluster_{$joinCounter}.functional_cluster_id" => $functionalClustersId]]);
            $joinCounter++;
        }
        $genesArray = $genesArrayQuery->all();
        return $genesArray;
    }
}