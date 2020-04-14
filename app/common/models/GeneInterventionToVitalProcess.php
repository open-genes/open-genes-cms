<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gene_intervention_to_vital_process".
 *
 * @property int $id
 * @property int $gene_id
 * @property int $gene_intervention_id
 * @property int $intervention_result_for_vital_process_id
 * @property int $vital_process_id
 * @property int $model_organism_id
 * @property int $organism_line_id
 * @property double $age
 * @property int $sex_of_organism
 * @property string $reference
 * @property string $comment_en
 * @property string $comment_ru
 * @property int $age_unit
 *
 * @property Gene $gene
 * @property InterventionResultForVitalProcess $interventionResultForVitalProcess
 * @property GeneIntervention $geneIntervention
 * @property ModelOrganism $modelOrganism
 * @property OrganismLine $organismLine
 * @property VitalProcess $vitalProcess
 */
class GeneInterventionToVitalProcess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gene_intervention_to_vital_process';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gene_id', 'gene_intervention_id', 'intervention_result_for_vital_process_id', 'vital_process_id', 'model_organism_id', 'organism_line_id', 'sex_of_organism', 'age_unit'], 'integer'],
            [['age'], 'number'],
            [['comment_en', 'comment_ru'], 'string'],
            [['reference'], 'string', 'max' => 255],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::className(), 'targetAttribute' => ['gene_id' => 'id']],
            [['intervention_result_for_vital_process_id'], 'exist', 'skipOnError' => true, 'targetClass' => InterventionResultForVitalProcess::className(), 'targetAttribute' => ['intervention_result_for_vital_process_id' => 'id']],
            [['gene_intervention_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeneIntervention::className(), 'targetAttribute' => ['gene_intervention_id' => 'id']],
            [['model_organism_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModelOrganism::className(), 'targetAttribute' => ['model_organism_id' => 'id']],
            [['organism_line_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganismLine::className(), 'targetAttribute' => ['organism_line_id' => 'id']],
            [['vital_process_id'], 'exist', 'skipOnError' => true, 'targetClass' => VitalProcess::className(), 'targetAttribute' => ['vital_process_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gene_id' => 'Gene ID',
            'gene_intervention_id' => 'Gene Intervention ID',
            'intervention_result_for_vital_process_id' => 'Intervention Result For Vital Process ID',
            'vital_process_id' => 'Vital Process ID',
            'model_organism_id' => 'Model Organism ID',
            'organism_line_id' => 'Organism Line ID',
            'age' => 'Age',
            'sex_of_organism' => 'Sex Of Organism',
            'reference' => 'Reference',
            'comment_en' => 'Comment En',
            'comment_ru' => 'Comment Ru',
            'age_unit' => 'Age Unit',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGene()
    {
        return $this->hasOne(Gene::className(), ['id' => 'gene_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterventionResultForVitalProcess()
    {
        return $this->hasOne(InterventionResultForVitalProcess::className(), ['id' => 'intervention_result_for_vital_process_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeneIntervention()
    {
        return $this->hasOne(GeneIntervention::className(), ['id' => 'gene_intervention_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModelOrganism()
    {
        return $this->hasOne(ModelOrganism::className(), ['id' => 'model_organism_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganismLine()
    {
        return $this->hasOne(OrganismLine::className(), ['id' => 'organism_line_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVitalProcess()
    {
        return $this->hasOne(VitalProcess::className(), ['id' => 'vital_process_id']);
    }

    /**
     * {@inheritdoc}
     * @return GeneInterventionToVitalProcessQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeneInterventionToVitalProcessQuery(get_called_class());
    }
}
