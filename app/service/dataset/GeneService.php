<?php

namespace app\service\dataset;

use app\models\Gene;

class GeneService
{
    /** @var LifespanExperimentService */
    private $lifespanExperimentService;

    /** @var GeneInterventionToVitalProcessService */
    private $geneInterventionToVitalProcessService;

    /** @var AgeRelatedChangeService */
    private $ageRelatedChangeService;

    public function __construct(
        LifespanExperimentService $lifespanExperimentService,
        GeneInterventionToVitalProcessService $geneInterventionToVitalProcessService,
        AgeRelatedChangeService $ageRelatedChangeService
    ) {
        $this->lifespanExperimentService = $lifespanExperimentService;
        $this->ageRelatedChangeService = $ageRelatedChangeService;
        $this->geneInterventionToVitalProcessService = $geneInterventionToVitalProcessService;
    }


    public function copyDataToData(array $data) {
        foreach ($data as $item) {
            $symbol = $item[0];
            $symbols = $item[1] ? explode(",", $item[1]) : [];
            $conditions = $item[2] ? explode(",", $item[2]) : [];
            $geneSymbols = [];
            $gene = Gene::find()->where(['symbol' => $symbol])->one();

            if (!empty($gene) && !empty($conditions) && !empty($symbols)) {
                $geneSymbols = Gene::find()->where(['in', 'symbol', $symbols])->all();

                // TODO: феолетовый
                if (!empty($gene->lifespanExperiments)) {
                    foreach ($gene->lifespanExperiments as $lifespanExperiment) {
                        if ($generalLifespanExperiment = $lifespanExperiment->generalLifespanExperiment) {
                            if (!empty($generalLifespanExperiment->model_organism_id)) {
                                if (in_array($generalLifespanExperiment->modelOrganism->name_ru, $conditions)) {
                                    $this
                                        ->lifespanExperimentService
                                        ->checkDuplicateAndSave($geneSymbols, $lifespanExperiment);
                                }
                            }
                        }
                    }
                }

                // TODO: зеленный
                if (!empty($gene->geneInterventionToVitalProcesses)) {
                    foreach ($gene->geneInterventionToVitalProcesses as $geneInterventionToVitalProcess) {
                        if (!empty($geneInterventionToVitalProcess->model_organism_id)) {
                            if (in_array($geneInterventionToVitalProcess->modelOrganism->name_ru, $conditions)) {
                                $this
                                    ->geneInterventionToVitalProcessService
                                    ->checkDuplicateAndSave($geneSymbols, $geneInterventionToVitalProcess);
                            }
                        }
                    }
                }

                // TODO: голубой
                if (!empty($gene->ageRelatedChanges)) {
                    foreach ($gene->ageRelatedChanges as $ageRelatedChange) {
                        if (!empty($ageRelatedChange->model_organism_id)) {
                            if (in_array($ageRelatedChange->modelOrganism->name_ru, $conditions)) {
                                $this
                                    ->ageRelatedChangeService
                                    ->checkDuplicateAndSave($geneSymbols, $ageRelatedChange);
                            }
                        }
                    }
                }

            }
        }

    }
}