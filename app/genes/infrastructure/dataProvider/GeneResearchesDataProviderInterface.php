<?php
namespace genes\infrastructure\dataProvider;

interface GeneResearchesDataProviderInterface
{
    /**
     * @param int $geneId
     * @param string $lang
     * @return array
     */
    public function getLifespanExperimentsByGeneId(int $geneId, string $lang): array;

    /**
     * @param int $geneId
     * @param string $lang
     * @return array
     */
    public function getAgeRelatedChangesByGeneId(int $geneId, string $lang): array;
    /**
     * @param int $geneId
     * @param string $lang
     * @return array
     */
    public function getGeneInterventionToVitalProcessByGeneId(int $geneId, string $lang): array;
    /**
     * @param int $geneId
     * @param string $lang
     * @return array
     */
    public function getProteinToGenesByGeneId(int $geneId, string $lang): array;
    /**
     * @param int $geneId
     * @param string $lang
     * @return array
     */
    public function getGeneToProgeriasByGeneId(int $geneId, string $lang): array;
    /**
     * @param int $geneId
     * @param string $lang
     * @return array
     */
    public function getGeneToLongevityEffectsByGeneId(int $geneId, string $lang): array;
}