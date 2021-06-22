<?php


namespace app\console\service;


interface ParseProteinAtlasServiceInterface
{
    public function parseFullAtlas(bool $onlyNew=true, array $geneNcbiIdsArray=[], string $geneSearchName='');

    public function parseClasses(bool $onlyNew=true, array $geneNcbiIdsArray=[], string $geneSearchName='');
}