<?php
namespace genes\application\service;

use genes\application\dto\GeneViewDto;

interface GeneInfoServiceInterface
{
    /**
     * @param int $geneId
     * @param string $lang
     * @return GeneViewDto
     */
    public function getGeneViewInfo(int $geneId, string $lang = 'en-US'): GeneViewDto;

    /**
     * @param int $count
     * @param string $lang
     * @return GeneViewDto[]
     */
    public function getLatestGenes(int $count, string $lang = 'en-US'): array;
    /**
     * @param int $count
     * @param string $lang
     * @return GeneViewDto[]
     */
    public function getAllGenes(int $count = null, string $lang = 'en-US'): array;
}