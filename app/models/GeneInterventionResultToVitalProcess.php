<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
use Yii;

/**
 * This is the model class for table "gene_intervention_result_to_vital_process".
 *
 * @property int $id
 * @property int|null $gene_intervention_to_vital_process_id
 * @property int|null $intervention_result_for_vital_process_id
 * @property int|null $vital_process_id
 *
 * @property VitalProcess $vitalProcess
 * @property InterventionResultForVitalProcess $interventionResultForVitalProcess
 * @property GeneInterventionToVitalProcess $gene
 */
class GeneInterventionResultToVitalProcess extends common\GeneInterventionResultToVitalProcess
{
    use RuEnActiveRecordTrait;

    public $name;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            ChangelogBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gene_intervention_to_vital_process_id' => 'Gene Intervention To Vital Process ID',
            'intervention_result_for_vital_process_id' => 'Intervention Result For Vital Process ID',
            'vital_process_id' => 'Vital Process ID',
        ];
    }

    public static function create($params)
    {
        $model = new self();
        foreach ($params as $key=>$value) {
            $model->$key = $value;
        }
        $model->save();
        return $model;
    }
}