<?php
namespace genes\infrastructure\dataProvider;

use yii\web\NotFoundHttpException;

interface GeneDataProviderInterface
{
    /**
     * @param $geneId
     * @return array
     * @throws NotFoundHttpException
     */
    public function getGene($geneId): array;
    
    public function getGeneBySymbol($geneId): array;

    public function getLatestGenes(int $count): array;

    public function getAllGenes(int $count = null): array;

    /**
     * @param int[] $functionalClustersIds
     * @return array
     */
    public function getByFunctionalClustersIds(array $functionalClustersIds): array;

    /**
     * @param int $expressionChange
     * @return array
     */
    public function getByExpressionChange(int $expressionChange): array;
    
    /**
     * @param string $term
     * @return array
     */
    public function getByGoTerm(string $term): array;
}