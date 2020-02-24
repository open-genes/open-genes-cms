<?php

namespace genes\application\dto;

class ResearchDtoAssembler implements ResearchDtoAssemblerInterface
{

    public function mapResearchDto(
        $lifespanExperiments,
        $geneToProgerias,
        $geneToLongevityEffects,
        $ageRelatedChanges,
        $interventionResultForVitalProcesses,
        $proteinToGenes,
        $lang
    ): ResearchDto
    {
        $researchesDto = new ResearchDto();
        foreach ($lifespanExperiments as $lifespanExperiment) {
            $this->preparePercentChange($lifespanExperiment);
            $this->prepareAge($lifespanExperiment, $lang);
            $researchesDto->increaseLifespan[] = $lifespanExperiment;
        }
        foreach ($geneToProgerias as $geneToProgeria) {
            $researchesDto->geneAssociatedWithProgeriaSyndromes[] = $geneToProgeria;
        }
        foreach ($geneToLongevityEffects as $geneToLongevityEffect) {
            $this->prepareSex($geneToLongevityEffect, $lang);
            $researchesDto->geneAssociatedWithLongevityEffects[] = $geneToLongevityEffect;
        }
        foreach ($ageRelatedChanges as $ageRelatedChange) {
            $this->prepareAge($ageRelatedChange, $lang);
            $this->preparePercentChange($ageRelatedChange);
            $researchesDto->ageRelatedChangesOfGene[] = $ageRelatedChange;
        }
        foreach ($interventionResultForVitalProcesses as $interventionResultForVitalProcess) {
            $this->prepareAge($interventionResultForVitalProcess, $lang);
            $this->prepareSex($interventionResultForVitalProcess, $lang);
            $researchesDto->interventionToGeneImprovesVitalProcesses[] = $interventionResultForVitalProcess;
        }
        foreach ($proteinToGenes as $proteinToGene) {
            $this->prepareGene($proteinToGene);
            $researchesDto->proteinRegulatesOtherGenes[] = $proteinToGene;
        }

        return $researchesDto;
    }

    private function prepareGene(&$data)
    {
        if (isset($data['regulatedGeneId'])) {
            $data['regulatedGene'] = [
                'id' => $data['regulatedGeneId'],
                'symbol' => $data['regulatedGeneSymbol'],
                'name' => $data['regulatedGeneName'],
                'entrezGene' => $data['regulatedGeneNcbiId'],
            ];
            unset($data['regulatedGeneId'], $data['regulatedGeneSymbol'], $data['regulatedGeneName'], $data['regulatedGeneNcbiId']);
        }
    }

    private function preparePercentChange(&$data)
    {
        $percentFields = ['valueForMale', 'valueForFemale', 'valueForAll'];
        foreach ($percentFields as $percentField) {
            if (isset($data[$percentField])) {
                $data[$percentField] .= '%';
            }
        }
    }

    private function prepareAge(&$data, $lang)
    {
        $ageUnits = $lang == 'en-US' ? [
            1 => 'days',
            2 => 'months',
            3 => 'years',
        ] : [
            1 => 'дн.',
            2 => 'мес.',
            3 => 'г.',
        ];
        $ageFields = ['age', 'ageFrom', 'ageTo'];

        foreach ($ageFields as $ageField) {
            if (isset($data[$ageField])) {
                if (isset($data['ageUnit']) && isset($ageUnits[$data['ageUnit']])) {
                    $data[$ageField] = $data[$ageField] . ' ' . $ageUnits[$data['ageUnit']];
                }
            }
        }
        unset($data['ageUnit']);
    }

    private function prepareSex(&$data, $lang)
    {
        $sexes = $lang == 'en-US' ? [
            0 => 'female',
            1 => 'male',
            2 => 'both',
        ] : [
            0 => 'женский',
            1 => 'мужской',
            2 => 'оба пола',
        ];
        if (isset($data['sex']) && isset($sexes[$data['sex']])) {
            $data['sex'] = $sexes[$data['sex']];
        }
    }
}