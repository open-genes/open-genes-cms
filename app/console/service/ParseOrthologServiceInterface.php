<?php

namespace app\console\service;

interface ParseOrthologServiceInterface
{
    public function parseHumanGeneFromGeneageFlies(string $geneAgeData, string $flybaseData);
    public function parseHumanGeneFromGeneageMice(string $geneAgeData);
    public function parseOrthologsFromFlybase(string $absolutePathToFile);
    public function parseOrthologsFromFlybaseInner(string $params);
}