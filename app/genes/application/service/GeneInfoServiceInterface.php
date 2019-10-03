<?php
namespace genes\application\service;

use genes\application\dto\GenViewDto;

interface GeneInfoServiceInterface
{
    public function getGeneViewInfo(int $geneId): GenViewDto;
}