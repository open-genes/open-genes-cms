<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "gene_intervention_to_vital_process".
 *
 * @property int $id
 * @property int|null $gene_id
 * @property int|null $gene_intervention_id
 * @property int|null $intervention_result_for_vital_process_id
 * @property int|null $vital_process_id
 * @property int|null $model_organism_id
 * @property int|null $organism_line_id
 * @property float|null $age
 * @property int|null $sex_of_organism
 * @property string|null $reference
 * @property string|null $comment_en
 * @property string|null $comment_ru
 * @property int|null $age_unit
 * @property int|null $genotype
 * @property string|null $pmid
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
            [['gene_id', 'gene_intervention_id', 'intervention_result_for_vital_process_id', 'vital_process_id', 'model_organism_id', 'organism_line_id', 'sex_of_organism', 'age_unit', 'genotype'], 'integer'],
            [['age'], 'number'],
            [['comment_en', 'comment_ru'], 'string'],
            [['reference', 'pmid'], 'string', 'max' => 255],
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
            'genotype' => 'Genotype',
            'pmid' => 'Pmid',
        ];
    }

    /**
     * Gets query for [[Gene]].
     *
     * @return \yii\db\ActiveQuery|GeneQuery
     */
    public function getGene()
    {
        return $this->hasOne(Gene::className(), ['id' => 'gene_id']);
    }

    /**
     * Gets query for [[InterventionResultForVitalProcess]].
     *
     * @return \yii\db\ActiveQuery|InterventionResultForVitalProcessQuery
     */
    public function getInterventionResultForVitalProcess()
    {
        return $this->hasOne(InterventionResultForVitalProcess::className(), ['id' => 'intervention_result_for_vital_process_id']);
    }

    /**
     * Gets query for [[GeneIntervention]].
     *
     * @return \yii\db\ActiveQuery|GeneInterventionQuery
     */
    public function getGeneIntervention()
    {
        return $this->hasOne(GeneIntervention::className(), ['id' => 'gene_intervention_id']);
    }

    /**
     * Gets query for [[ModelOrganism]].
     *
     * @return \yii\db\ActiveQuery|ModelOrganismQuery
     */
    public function getModelOrganism()
    {
        return $this->hasOne(ModelOrganism::className(), ['id' => 'model_organism_id']);
    }

    /**
     * Gets query for [[OrganismLine]].
     *
     * @return \yii\db\ActiveQuery|OrganismLineQuery
     */
    public function getOrganismLine()
    {
        return $this->hasOne(OrganismLine::className(), ['id' => 'organism_line_id']);
    }

    /**
     * Gets query for [[VitalProcess]].
     *
     * @return \yii\db\ActiveQuery|VitalProcessQuery
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
