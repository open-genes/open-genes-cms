<?php

namespace app\service\dataset;


use app\models\AgeRelatedChange;
use app\models\AgeRelatedChangeType;
use app\models\ExpressionEvaluation;
use app\models\Gene;
use app\models\MeasurementMethod;
use app\models\ModelOrganism;
use app\models\OrganismSex;
use app\models\StatisticalMethod;

class AgeRelatedChangeService
{

    public function humanChangeSerumExperiments(array $dataset) {
        $organismSexes = OrganismSex::find()->all();

        foreach ($dataset as $data) {
            $gene = Gene::find()->where(['symbol' => $data[0]])->one();
            if (empty($gene)) {
                continue;
            }

            $modelOrganism = ModelOrganism::find()->where(['name_en' => $data[1]])->one();
            if (empty($modelOrganism)) {
                continue;
            }

            $ageRelatedChangeType = AgeRelatedChangeType::find()->where(['name_en' => $data[7]])->one();
            if (empty($ageRelatedChangeType)) {
                continue;
            }

            $expressionEvaluation = ExpressionEvaluation::find()->where(['name_en' => $data[8]])->one();
            if (empty($expressionEvaluation)) {
                continue;
            }

            $organismSexId = 0;
            if (!empty($organismSexes)) {
                foreach ($organismSexes as $organismSex) {
                    if ($organismSex->name_en === $data[9]) {
                        $organismSexId = $organismSex->id;
                    }
                }
            }

            $measurementMethod = MeasurementMethod::find()->where(['name_en' => $data[10]])->one();
            if (empty($measurementMethod)) {
                continue;
            }

            $statisticalMethod = StatisticalMethod::find()->where(['name_en' => $data[11]])->one();
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
            } catch (\Exception $exception) {
                var_dump($exception->getMessage());
                continue;
            }
        }

        echo 'success END import' . PHP_EOL;
    }

}