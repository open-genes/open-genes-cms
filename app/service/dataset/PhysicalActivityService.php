<?php

namespace app\service\dataset;

use app\models\ExpressionEvaluation;
use app\models\Gene;
use app\models\MeasurementMethod;
use app\models\ModelOrganism;
use app\models\OrganismLine;
use app\models\OrganismSex;
use app\models\common\PhysicalActivity;
use app\models\Sample;

class PhysicalActivityService
{

    public function fillTable(array $dataset) {

        foreach ($dataset as $data) {
            $geneSymbol = trim($data[0]);
            if (!empty($geneSymbol)) {
                $gene = Gene::find()->where(['symbol' => $geneSymbol])->one();
                if (empty($gene)) {
                    continue;
                }

                $sample = strtolower($data[3]);
                $tissue = Sample::find()->where(['name_en' => $sample])->one();
                if (empty($tissue)) {
                    continue;
                }

                $expressionEvaluationBy = $data[6];
                $expressionEvaluation = ExpressionEvaluation::find()->where(['name_en' => $expressionEvaluationBy])->one();
                if (empty($expressionEvaluation)) {
                    continue;
                }

                $modelOrganismName = $data[10];
                $modelOrganism = ModelOrganism::find()->where(['name_en' => $modelOrganismName])->one();
                if (empty($modelOrganism)) {
                    continue;
                }

                $organismLineName = !empty($data[11]) ? $data[11] == 'n/a' ? null : $data[11] : null;
                if ($organismLineName) {
                    $organismLine = OrganismLine::find()->where(['name_en' => $organismLineName])->one();
                }

                $organismSexName = $data[12];
                $organismSex = OrganismSex::find()->where(['name_en' => $organismSexName])->one();
                if (empty($organismSex)) {
                    continue;
                }

                $physicalActivity = new PhysicalActivity();
                $physicalActivity->gene_id = $gene->id;
                $physicalActivity->tissue_id = $tissue->id;
                $physicalActivity->expression_evaluation_id = $expressionEvaluation->id;
                $physicalActivity->model_organism_id = $modelOrganism->id;
                $physicalActivity->organism_line_id = !empty($organismLineName) && $organismLine ? $organismLine->id : null;
                $physicalActivity->organism_sex_id = $organismSex->id;
                $physicalActivity->p_value = $data[2];
                $physicalActivity->after_sport_result = $data[4];
                $physicalActivity->time_point = $data[7];
                $physicalActivity->training_regimen = $data[9];
                $physicalActivity->sportsman = $data[13];
                $physicalActivity->age = $data[14];
                $physicalActivity->age_units = $data[15];
                $physicalActivity->experiment_groups_quantity = $data[16];
                $physicalActivity->link = $data[17];
                $physicalActivity->expression_change_log = $data[20];

                $measurementMethodNames = explode(',', trim($data[5]));
                foreach ($measurementMethodNames as $name) {
                    $measurementMethod = MeasurementMethod::find()->where(['name_en' => $name])->one();
                    if (!empty($measurementMethod)) {
                        $physicalActivity->measurement_method_id = $measurementMethod->id;
                        try {
                            $physicalActivity->save();
                            echo 'SUCCESS: ' . $geneSymbol . PHP_EOL;
                        } catch (\Exception $exception) {
                            var_dump($exception->getMessage());
                            continue;
                        }
                    }
                }
            }

        }
    }
}