<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "gene_intervention_result_to_vital_process".
 *
 * @property int $id
 * @property int|null $gene_id
 * @property int|null $intervention_result_for_vital_process_id
 * @property int|null $vital_process_id
 *
 * @property VitalProcess $vitalProcess
 * @property InterventionResultForVitalProcess $interventionResultForVitalProcess
 * @property GeneInterventionToVitalProcess $gene
 */
class GeneInterventionResultToVitalProcess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gene_intervention_result_to_vital_process';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gene_intervention_to_vital_process_id', 'intervention_result_for_vital_process_id', 'vital_process_id'], 'integer'],
            [['vital_process_id'], 'exist', 'skipOnError' => true, 'targetClass' => VitalProcess::class, 'targetAttribute' => ['vital_process_id' => 'id']],
            [['intervention_result_for_vital_process_id'], 'exist', 'skipOnError' => true, 'targetClass' => InterventionResultForVitalProcess::class, 'targetAttribute' => ['intervention_result_for_vital_process_id' => 'id']],
            [['gene_intervention_to_vital_process_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeneInterventionToVitalProcess::class, 'targetAttribute' => ['gene_intervention_to_vital_process_id' => 'id']],
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
     * Gets query for [[Gene]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGene()
    {
        return $this->hasOne(GeneInterventionToVitalProcess::class, ['gene_id' => 'gene_id']);
    }
}