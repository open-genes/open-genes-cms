<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "lifespan_experiment_to_vital_process".
 *
 * @property int $id
 * @property int|null $general_lifespan_experiment_id
 * @property int|null $intervention_result_for_vital_process_id
 * @property int|null $vital_process_id
 *
 * @property VitalProcess $vitalProcess
 * @property InterventionResultForVitalProcess $interventionResultForVitalProcess
 * @property LifespanExperiment $lifespanExperiment
 */
class GeneralLifespanExperimentToVitalProcess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'general_lifespan_experiment_to_vital_process';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['general_lifespan_experiment_id', 'intervention_result_for_vital_process_id', 'vital_process_id'], 'integer'],
            [['vital_process_id'], 'exist', 'skipOnError' => true, 'targetClass' => VitalProcess::class, 'targetAttribute' => ['vital_process_id' => 'id']],
            [['intervention_result_for_vital_process_id'], 'exist', 'skipOnError' => true, 'targetClass' => InterventionResultForVitalProcess::class, 'targetAttribute' => ['intervention_result_for_vital_process_id' => 'id']],
            [['general_lifespan_experiment_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeneralLifespanExperiment::class, 'targetAttribute' => ['general_lifespan_experiment_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'general_lifespan_experiment_id' => 'General Lifespan Experiment ID',
            'intervention_result_for_vital_process_id' => 'Intervention Result For Vital Process ID',
            'vital_process_id' => 'Vital Process ID',
        ];
    }

    /**
     * Gets query for [[VitalProcess]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVitalProcess()
    {
        return $this->hasOne(VitalProcess::class, ['id' => 'vital_process_id']);
    }

    /**
     * Gets query for [[InterventionResultForVitalProcess]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInterventionResultForVitalProcess()
    {
        return $this->hasOne(InterventionResultForVitalProcess::class, ['id' => 'intervention_result_for_vital_process_id']);
    }

    /**
     * Gets query for [[LifespanExperiment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGeneralLifespanExperiment()
    {
        return $this->hasOne(GeneralLifespanExperiment::class, ['id' => 'general_lifespan_experiment_id']);
    }
}
