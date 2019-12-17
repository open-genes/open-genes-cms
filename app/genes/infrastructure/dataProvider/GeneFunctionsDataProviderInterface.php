<?php
namespace genes\infrastructure\dataProvider;

interface GeneFunctionsDataProviderInterface
{
    /**
     * @param int $geneId
     * @param string $lang
     * @return array
     */
    public function getByGeneId(int $geneId, string $lang): array;
}