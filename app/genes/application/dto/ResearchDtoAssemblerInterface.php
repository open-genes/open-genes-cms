<?php

namespace genes\application\dto;

interface ResearchDtoAssemblerInterface
{
    /**
     * @param array $lifespanExperiments
     * @param array $geneToProgerias
     * @param array $geneToLongevityEffects
     * @param array $ageRelatedChanges
     * @param array $interventionResultForVitalProcesses
     * @param array $proteinToGenes
     * @param string $lang
     * @return ResearchDto
     */
    public function mapResearchDto(
        $lifespanExperiments,
        $geneToProgerias,
        $geneToLongevityEffects,
        $ageRelatedChanges,
        $interventionResultForVitalProcesses,
        $proteinToGenes,
        $lang
    ): ResearchDto;
}