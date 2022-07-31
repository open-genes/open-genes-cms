<?php

namespace app\service\dataset;

use app\models\AgeRelatedChange;
use app\models\common\GeneralLifespanExperiment;
use app\models\common\GeneToSource;
use app\models\common\LifespanExperiment;
use app\models\Gene;
use app\models\GeneInterventionToVitalProcess;
use app\models\Source;
use phpDocumentor\Reflection\Types\Null_;

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

                foreach ($conditions as $condition) {

                    // TODO: феолетовый
                    if ($generalLifespanExperiments = GeneralLifespanExperiment::find()
                        ->innerJoin('lifespan_experiment as le', 'general_lifespan_experiment.id=le.general_lifespan_experiment_id')
                        ->innerJoin('model_organism as mo', 'general_lifespan_experiment.model_organism_id=mo.id')
                        ->where([
                            'mo.name_ru' => $condition,
                            'le.gene_id' => $gene->id
                        ])
                        ->all()) {

                        foreach ($generalLifespanExperiments as $generalLifespanExperiment) {
                            /** @var $generalLifespanExperiment GeneralLifespanExperiment */
                            foreach ($generalLifespanExperiment->lifespanExperiments as $lifespanExperiment) {
                                $this
                                    ->lifespanExperimentService
                                    ->checkDuplicateAndSave($geneSymbols, $lifespanExperiment);
                            }
                        }
                    }

                    // TODO: зеленный
                    if ($geneInterventionToVitalProcesses = GeneInterventionToVitalProcess::find()
                        ->innerJoin('model_organism as mo', 'mo.id=gene_intervention_to_vital_process.model_organism_id')
                        ->where([
                            'mo.name_ru' => $condition,
                            'gene_intervention_to_vital_process.gene_id' => $gene->id
                        ])
                        ->all()) {
                        foreach ($geneInterventionToVitalProcesses as $geneInterventionToVitalProcess) {
                            $this
                                ->geneInterventionToVitalProcessService
                                ->checkDuplicateAndSave($geneSymbols, $geneInterventionToVitalProcess);
                        }
                    }

                    // TODO: голубой
                    if ($ageRelatedChanges = AgeRelatedChange::find()
                        ->innerJoin('model_organism as mo', 'mo.id=age_related_change.model_organism_id')
                        ->where([
                            'mo.name_ru' => $condition,
                            'age_related_change.gene_id' => $gene->id
                        ])
                        ->all()) {
                        foreach ($ageRelatedChanges as $ageRelatedChange) {
                            $this
                                ->ageRelatedChangeService
                                ->checkDuplicateAndSave($geneSymbols, $ageRelatedChange);
                        }
                    }
                }
            }
        }

    }

    public function addSourceToGene(array $data) {
        if ($source = Source::find()->where('GeneAge')->one()) {
            foreach ($data as $item) {
                $symbol = trim($item[0]);
                if ($gene = Gene::find()->where(['symbol' => $symbol])->one()) {
                    if (GeneToSource::find()->where([
                        'gene_id' => $gene->id,
                        'source_id' => $source->id
                    ])->one()) {
                        $geneToSource = new GeneToSource();
                        $geneToSource->gene_id = $gene->id;
                        $geneToSource->source_id = $source->id;
                        try {
                            $geneToSource->save();
                            echo 'success: ' . $symbol . PHP_EOL;
                        } catch (\Exception $exception) {
                            var_dump($exception->getMessage());
                            continue;
                        }
                    } else {
                        echo 'has: ' . $symbol . PHP_EOL;
                    }
                } else {
                    echo 'такого гена нет: ' . $symbol . PHP_EOL;
                }
            }
        } else {
            echo 'Источника GeneAge несуществует' . PHP_EOL;
        }
    }
}