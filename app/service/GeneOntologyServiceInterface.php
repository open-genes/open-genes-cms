<?php

namespace app\service;

interface GeneOntologyServiceInterface
{
    public function mineFromGatewayForGene($geneNcbiId, $rows);

    public function getAllWithGenes();

    public function getForGene($id);
}