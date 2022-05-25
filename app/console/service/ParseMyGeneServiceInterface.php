<?php


namespace app\console\service;


use app\models\Gene;

interface ParseMyGeneServiceInterface
{
    public function parseInfo(bool $onlyNew=true, array $geneNcbiIdsArray=[]);

    public function parseBySymbol(string $symbol);

}