<?php

namespace app\service\dataset;


use app\models\common\AgeRelatedChange;
use app\models\AgeRelatedChange as AgeRelatedChangeModel;
use app\models\AgeRelatedChangeType;
use app\models\ExpressionEvaluation;
use app\models\Gene;
use app\models\MeasurementMethod;
use app\models\ModelOrganism;
use app\models\OrganismSex;
use app\models\StatisticalMethod;

class AgeRelatedChangeService
{

    public function expressionChangeHumanMrna(array $dataset) {
        $organismSexes = OrganismSex::find()->all();

        foreach ($dataset as $data) {
            if ($geneSymbol = $data[1]) {
                $gene = Gene::find()->where(['symbol' => $geneSymbol])->one();
                if (empty($gene)) {
                    continue;
                }

                $modelOrganism = ModelOrganism::find()->where(['name_en' => $data[3]])->one();
                if (empty($modelOrganism)) {
                    continue;
                }

                $ageRelatedChangeType = AgeRelatedChangeType::find()->where(['name_en' => $data[6]])->one();
                if (empty($ageRelatedChangeType)) {
                    continue;
                }

                $expressionEvaluation = ExpressionEvaluation::find()->where(['name_en' => $data[7]])->one();
                if (empty($expressionEvaluation)) {
                    continue;
                }

                $organismSexId = 0;
                if (!empty($organismSexes)) {
                    foreach ($organismSexes as $organismSex) {
                        if ($organismSex->name_en === $data[8]) {
                            $organismSexId = $organismSex->id;
                        }
                    }
                }

                $measurementMethod = MeasurementMethod::find()->where(['name_en' => $data[9]])->one();
                if (empty($measurementMethod)) {
                    continue;
                }

                $statisticalMethod = StatisticalMethod::find()->where(['name_en' => $data[10]])->one();
                if (empty($statisticalMethod)) {
                    continue;
                }

                $ageRelatedChange = new AgeRelatedChange();
                $ageRelatedChange->gene_id = $gene->id;
                $ageRelatedChange->model_organism_id = $modelOrganism->id;
                $ageRelatedChange->age_related_change_type_id = $ageRelatedChangeType->id;
                $ageRelatedChange->expression_evaluation_by_id = $expressionEvaluation->id;
                $ageRelatedChange->sex = $organismSexId;
                $ageRelatedChange->measurement_method_id = $measurementMethod->id;
                $ageRelatedChange->statistical_method_id = $statisticalMethod->id;
                try {
                    $ageRelatedChange->save();
                    echo 'success gene: ' . $geneSymbol . PHP_EOL;
                } catch (\Exception $exception) {
                    var_dump($exception->getMessage());
                    continue;
                }
            }
        }

        echo 'success END import' . PHP_EOL;
    }

    public function checkDuplicateAndSave($geneSymbols, AgeRelatedChangeModel $ageRelatedChange) {
        /** @var Gene $geneSymbol */
        foreach ($geneSymbols as $geneSymbol) {
            $ccAgeRelatedChange = AgeRelatedChangeModel::find()
                ->where(['gene_id' => $geneSymbol->id])
                ->one();

            if (empty($ccAgeRelatedChange)) {
                $this->saveByGene($geneSymbol->id, $ageRelatedChange);
                echo 'saveBlue :' . $geneSymbol->symbol . PHP_EOL;
            }
        }
    }

    private function saveByGene(int $geneId, AgeRelatedChangeModel $ageRelatedChange) {
        $item = new AgeRelatedChange();
        $item->gene_id = $geneId;
        $item->age_related_change_type_id = $ageRelatedChange->age_related_change_type_id;
        $item->sample_id = $ageRelatedChange->sample_id;
        $item->model_organism_id = $ageRelatedChange->model_organism_id;
        $item->organism_line_id = $ageRelatedChange->organism_line_id;
        $item->mean_age_of_controls = $ageRelatedChange->mean_age_of_controls;
        $item->mean_age_of_experiment = $ageRelatedChange->mean_age_of_experiment;
        $item->reference = $ageRelatedChange->reference;
        $item->comment_en = $ageRelatedChange->comment_en;
        $item->comment_ru = $ageRelatedChange->comment_ru;
        $item->age_unit_id = $ageRelatedChange->age_unit_id;
        $item->expression_evaluation_by_id = $ageRelatedChange->expression_evaluation_by_id;
        $item->pmid = $ageRelatedChange->pmid;
        $item->min_age_of_controls = $ageRelatedChange->min_age_of_controls;
        $item->max_age_of_controls = $ageRelatedChange->max_age_of_controls;
        $item->min_age_of_experiment = $ageRelatedChange->min_age_of_experiment;
        $item->max_age_of_experiment = $ageRelatedChange->max_age_of_experiment;
        $item->n_of_controls = $ageRelatedChange->n_of_controls;
        $item->n_of_experiment = $ageRelatedChange->n_of_experiment;
        $item->measurement_method_id = $ageRelatedChange->measurement_method_id;
        $item->statistical_method_id = $ageRelatedChange->statistical_method_id;
        $item->p_value = $ageRelatedChange->p_value;
        $item->sex = $ageRelatedChange->sex;
        $item->change_value = $ageRelatedChange->change_value;
        $item->save();
    }

}