<?php
namespace genes\infrastructure\dataProvider;

interface GeneExpressionDataProviderInterface
{
    /**
     * @param int $geneId
     * @param string $lang
     * @return array
     */
    public function getByGeneId(int $geneId, string $lang): array;
}