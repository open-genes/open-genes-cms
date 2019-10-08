<?php
namespace genes\application\service;

use genes\application\dto\GeneViewDto;

interface GeneInfoServiceInterface
{
    /**
     * @param int $geneId
     * @return GeneViewDto
     * @throws \yii\web\NotFoundHttpException
     */
    public function getGeneViewInfo(int $geneId): GeneViewDto;

    /**
     * @param int $count
     * @return GeneViewDto[]
     */
    public function getLatestGenes(int $count): array;
    /**
     * @param int $count
     * @return GeneViewDto[]
     */
    public function getAllGenes(int $count = null): array;
}