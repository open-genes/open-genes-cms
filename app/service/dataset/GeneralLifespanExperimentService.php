<?php

namespace app\service\dataset;

use app\models\common\GeneralLifespanExperiment;

class GeneralLifespanExperimentService
{
    public function saveByGene(GeneralLifespanExperiment $generalLifespanExperiment) {
        $gleData = new GeneralLifespanExperiment();
        $gleData->name = $generalLifespanExperiment->name;
        $gleData->control_lifespan_min = $generalLifespanExperiment->control_lifespan_min;
        $gleData->control_lifespan_mean = $generalLifespanExperiment->control_lifespan_mean;
        $gleData->control_lifespan_median = $generalLifespanExperiment->control_lifespan_median;
        $gleData->control_lifespan_max = $generalLifespanExperiment->control_lifespan_max;
        $gleData->experiment_lifespan_min = $generalLifespanExperiment->experiment_lifespan_min;
        $gleData->experiment_lifespan_mean = $generalLifespanExperiment->experiment_lifespan_mean;
        $gleData->experiment_lifespan_median = $generalLifespanExperiment->experiment_lifespan_median;
        $gleData->experiment_lifespan_max = $generalLifespanExperiment->experiment_lifespan_max;
        $gleData->lifespan_min_change = $generalLifespanExperiment->lifespan_min_change;
        $gleData->lifespan_mean_change = $generalLifespanExperiment->lifespan_mean_change;
        $gleData->lifespan_median_change = $generalLifespanExperiment->lifespan_median_change;
        $gleData->lifespan_max_change = $generalLifespanExperiment->lifespan_max_change;
        $gleData->control_number = $generalLifespanExperiment->control_number;
        $gleData->experiment_number = $generalLifespanExperiment->experiment_number;
        $gleData->organism_number_in_cage = $generalLifespanExperiment->organism_number_in_cage;
        $gleData->expression_change = $generalLifespanExperiment->expression_change;
        $gleData->changed_expression_tissue_id = $generalLifespanExperiment->changed_expression_tissue_id;
        $gleData->lifespan_change_time_unit_id = $generalLifespanExperiment->lifespan_change_time_unit_id;
        $gleData->age = $generalLifespanExperiment->age;
        $gleData->age_unit_id = $generalLifespanExperiment->age_unit_id;
        $gleData->intervention_result_id = $generalLifespanExperiment->intervention_result_id;
        $gleData->lifespan_change_percent_male = $generalLifespanExperiment->lifespan_change_percent_male;
        $gleData->lifespan_change_percent_female = $generalLifespanExperiment->lifespan_change_percent_female;
        $gleData->lifespan_change_percent_common = $generalLifespanExperiment->lifespan_change_percent_common;
        $gleData->lifespan_min_change_stat_sign_id = $generalLifespanExperiment->lifespan_min_change_stat_sign_id;
        $gleData->lifespan_mean_change_stat_sign_id = $generalLifespanExperiment->lifespan_mean_change_stat_sign_id;
        $gleData->lifespan_median_change_stat_sign_id = $generalLifespanExperiment->lifespan_median_change_stat_sign_id;
        $gleData->lifespan_max_change_stat_sign_id = $generalLifespanExperiment->lifespan_max_change_stat_sign_id;
        $gleData->model_organism_id = $generalLifespanExperiment->model_organism_id;
        $gleData->organism_line_id = $generalLifespanExperiment->organism_line_id;
        $gleData->organism_sex_id = $generalLifespanExperiment->organism_sex_id;
        $gleData->reference = $generalLifespanExperiment->reference;
        $gleData->pmid = $generalLifespanExperiment->pmid;
        $gleData->comment_en = $generalLifespanExperiment->comment_en;
        $gleData->comment_ru = $generalLifespanExperiment->comment_ru;
        $gleData->expression_evaluation_by_id = $generalLifespanExperiment->expression_evaluation_by_id;
        $gleData->temperature_from = $generalLifespanExperiment->temperature_from;
        $gleData->temperature_to = $generalLifespanExperiment->temperature_to;
        $gleData->diet_id = $generalLifespanExperiment->diet_id;
        $gleData->save();
    }
}