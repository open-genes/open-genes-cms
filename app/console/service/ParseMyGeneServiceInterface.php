<?php


namespace app\console\service;


interface ParseMyGeneServiceInterface
{
    public function parseInfo(bool $onlyNew=true, array $geneNcbiIdsArray=[]);

    public function parseBySymbol(string $symbol) : string;

}