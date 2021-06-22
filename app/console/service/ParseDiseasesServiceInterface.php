<?php


namespace app\console\service;


interface ParseDiseasesServiceInterface
{
    public function parseBiocomp(bool $onlyNew=true, array $geneNcbiIdsArray=[]);

}