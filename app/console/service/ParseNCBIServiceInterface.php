<?php


namespace app\console\service;


interface ParseNCBIServiceInterface
{
    public function parseExpression(bool $onlyNew=true, array $geneNcbiIdsArray=[]);

    public function parseOrthologs($geneIdsAfter, $limit);

}