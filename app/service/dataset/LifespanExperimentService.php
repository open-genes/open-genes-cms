<?php

namespace app\service\dataset;

use app\models\common\GeneralLifespanExperiment;
//use app\models\LifespanExperiment as LifespanExperimentModel;
use app\models\common\LifespanExperiment;
use app\models\Gene;

class LifespanExperimentService
{

    /** @var GeneralLifespanExperimentService */
    private $generalLifespanExperimentService;

    public function __construct(GeneralLifespanExperimentService $generalLifespanExperimentService) {
        $this->generalLifespanExperimentService = $generalLifespanExperimentService;
    }

    public function checkDuplicateAndSave($geneSymbols, LifespanExperiment $lifespanExperiment) {
        $generalLifespanExperiment = $lifespanExperiment->generalLifespanExperiment;
        /** @var Gene $geneSymbol */
        echo 'checkDuplicateAndSave' . PHP_EOL;
        foreach ($geneSymbols as $geneSymbol) {
            $geneSymbolGeneralLifespanExperiment = GeneralLifespanExperiment::find()
                ->innerJoin('lifespan_experiment as le', 'general_lifespan_experiment.id=le.general_lifespan_experiment_id')
                ->where(['le.gene_id' => $geneSymbol->id])
                ->andWhere(['general_lifespan_experiment.id' => $generalLifespanExperiment->id])
                ->one();
            if (empty($geneSymbolGeneralLifespanExperiment)) {
                $gle = $this->generalLifespanExperimentService->saveByGene($generalLifespanExperiment);

                $this->saveByGene($geneSymbol->id, $lifespanExperiment, $gle);
                echo 'savePurple :' . $geneSymbol->symbol . PHP_EOL;
            } else {
                echo 'has' . PHP_EOL;
            }
        }
    }

    public function saveByGene(int $gene_id, LifespanExperiment $lifespanExperiment, GeneralLifespanExperiment $gle) {
        $leData = new LifespanExperiment();
        $leData->gene_id = $gene_id;
        $leData->ortholog_id = $lifespanExperiment->ortholog_id;
        $leData->gene_intervention_id = $lifespanExperiment->gene_intervention_id;
        $leData->age = $lifespanExperiment->age;
        $leData->reference = $lifespanExperiment->reference;
        $leData->comment_en = $lifespanExperiment->comment_en;
        $leData->comment_ru = $lifespanExperiment->comment_ru;
        $leData->age_unit = $lifespanExperiment->age_unit;
        $leData->genotype = $lifespanExperiment->genotype;
        $leData->pmid = $lifespanExperiment->pmid;
        $leData->tissue_specificity = $lifespanExperiment->tissue_specificity;
        $leData->tissue_specific_promoter = $lifespanExperiment->tissue_specific_promoter;
        $leData->mutation_induction = $lifespanExperiment->mutation_induction;
        $leData->treatment_start = $lifespanExperiment->treatment_start;
        $leData->treatment_end = $lifespanExperiment->treatment_end;
        $leData->active_substance_id = $lifespanExperiment->active_substance_id;
        $leData->active_substance_delivery_way_id = $lifespanExperiment->active_substance_delivery_way_id;
        $leData->treatment_period_id = $lifespanExperiment->treatment_period_id;
        $leData->gene_intervention_method_id = $lifespanExperiment->gene_intervention_method_id;
        $leData->gene_intervention_way_id = $lifespanExperiment->gene_intervention_way_id;
        $leData->experiment_main_effect_id = $lifespanExperiment->experiment_main_effect_id;
        $leData->treatment_start_stage_of_development_id = $lifespanExperiment->treatment_start_stage_of_development_id;
        $leData->treatment_end_stage_of_development_id = $lifespanExperiment->treatment_end_stage_of_development_id;
        $leData->treatment_start_time_unit_id = $lifespanExperiment->treatment_start_time_unit_id;
        $leData->treatment_end_time_unit_id = $lifespanExperiment->treatment_end_time_unit_id;
        $leData->general_lifespan_experiment_id = $gle->id;
        $leData->type = $lifespanExperiment->type;
        $leData->description_of_therapy_ru = $lifespanExperiment->description_of_therapy_ru;
        $leData->description_of_therapy_en = $lifespanExperiment->description_of_therapy_en;
        $leData->organism_line_id = $lifespanExperiment->organism_line_id;
        $leData->save();
    }
}