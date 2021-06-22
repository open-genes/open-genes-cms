<?php

namespace app\service;

interface GeneOntologyServiceInterface
{
    public function mineFromGatewayForGene($geneNcbiId, $rows = 1000);

    public function getAllWithGenes();

    public function getForGene($id);
}