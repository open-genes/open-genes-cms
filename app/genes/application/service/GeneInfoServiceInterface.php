<?php
namespace genes\application\service;

use genes\application\dto\GeneFullViewDto;
use genes\application\dto\GeneListViewDto;
use genes\application\dto\LatestGeneViewDto;

interface GeneInfoServiceInterface
{
    /**
     * @param int $geneId
     * @param string $lang
     * @return GeneFullViewDto
     */
    public function getGeneViewInfo(int $geneId, string $lang = 'en-US'): GeneFullViewDto;

    /**
     * @param int $count
     * @param string $lang
     * @return LatestGeneViewDto[]
     */
    public function getLatestGenes(int $count, string $lang = 'en-US'): array;
    /**
     * @param int $count
     * @param string $lang
     * @return GeneListViewDto[]
     */
    public function getAllGenes(int $count = null, string $lang = 'en-US'): array;
}