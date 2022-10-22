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

                $sample = strtolower($data[5]);
                if (trim($sample)) {
                    $tissue = Sample::find()->where(['name_en' => $sample])->one();
                }

                $expressionEvaluationBy = $data[12];
                if (trim($expressionEvaluationBy)) {
                    $expressionEvaluation = ExpressionEvaluation::find()->where(['name_en' => $expressionEvaluationBy])->one();
                }

                $modelOrganismName = $data[6];
                if (trim($modelOrganismName)) {
                    $modelOrganism = ModelOrganism::find()->where(['name_en' => $modelOrganismName])->one();
                }

                $organismLineName = !empty($data[8]) ? $data[8] == 'n/a' ? null : $data[8] : null;
                if (trim($organismLineName)) {
                    $organismLine = OrganismLine::find()->where(['name_en' => $organismLineName])->one();
                }

                $organismSexName = $data[7];
                if (trim($organismSexName)) {
                    $organismSex = OrganismSex::find()->where(['name_en' => $organismSexName])->one();
                }

                $physicalActivity = new PhysicalActivity();
                $physicalActivity->gene_id = $gene->id;
                $physicalActivity->tissue_id = $tissue->id ?? null;
                $physicalActivity->expression_evaluation_id = $expressionEvaluation->id ?? null;
                $physicalActivity->model_organism_id = $modelOrganism->id ?? null;
                $physicalActivity->organism_line_id = !empty($organismLineName) && $organismLine ? $organismLine->id : null;
                $physicalActivity->organism_sex_id = $organismSex->id ?? null;
                $physicalActivity->p_value = $data[4];
                $physicalActivity->result = $data[1];
                $physicalActivity->measurement_taken = $data[13];
                $physicalActivity->training_regimen = $data[15];
                $physicalActivity->participants = $data[16];
                $physicalActivity->duration = $data[14];
                $physicalActivity->age = $data[9];
                $physicalActivity->age_units = $data[10];
                $physicalActivity->experiment_groups_quantity = $data[17];
                $physicalActivity->reference = $data[18];
                $physicalActivity->expression_change_log = $data[3];

                $measurementMethodNames = explode(',', trim($data[11]));
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