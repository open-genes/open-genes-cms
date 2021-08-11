<?php


namespace app\console\service;


interface ParseICDServiceInterface
{
    public function getICDTree(bool $onlyNew=true, array $geneNcbiIdsArray=[]);

}