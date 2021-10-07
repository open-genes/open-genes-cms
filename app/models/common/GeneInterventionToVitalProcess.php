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
 * @property int|null $gene_intervention_method_id
 *
 * @property GeneInterventionMethod $geneInterventionMethod
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
            [['gene_id', 'gene_intervention_id', 'intervention_result_for_vital_process_id', 'vital_process_id', 'model_organism_id', 'organism_line_id', 'sex_of_organism', 'age_unit', 'genotype', 'gene_intervention_method_id'], 'integer'],
            [['age'], 'number'],
            [['comment_en', 'comment_ru'], 'string'],
            [['reference', 'pmid'], 'string', 'max' => 255],
            [['gene_intervention_method_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeneInterventionMethod::class, 'targetAttribute' => ['gene_intervention_method_id' => 'id']],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::class, 'targetAttribute' => ['gene_id' => 'id']],
            [['intervention_result_for_vital_process_id'], 'exist', 'skipOnError' => true, 'targetClass' => InterventionResultForVitalProcess::class, 'targetAttribute' => ['intervention_result_for_vital_process_id' => 'id']],
            [['gene_intervention_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeneIntervention::class, 'targetAttribute' => ['gene_intervention_id' => 'id']],
            [['model_organism_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModelOrganism::class, 'targetAttribute' => ['model_organism_id' => 'id']],
            [['organism_line_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganismLine::class, 'targetAttribute' => ['organism_line_id' => 'id']],
            [['vital_process_id'], 'exist', 'skipOnError' => true, 'targetClass' => VitalProcess::class, 'targetAttribute' => ['vital_process_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'gene_id' => Yii::t('app', 'Gene ID'),
            'gene_intervention_id' => Yii::t('app', 'Gene Intervention ID'),
            'intervention_result_for_vital_process_id' => Yii::t('app', 'Intervention Result For Vital Process ID'),
            'vital_process_id' => Yii::t('app', 'Vital Process ID'),
            'model_organism_id' => Yii::t('app', 'Model Organism ID'),
            'organism_line_id' => Yii::t('app', 'Organism Line ID'),
            'age' => Yii::t('app', 'Age'),
            'sex_of_organism' => Yii::t('app', 'Sex Of Organism'),
            'reference' => Yii::t('app', 'Reference'),
            'comment_en' => Yii::t('app', 'Comment En'),
            'comment_ru' => Yii::t('app', 'Comment Ru'),
            'age_unit' => Yii::t('app', 'Age Unit'),
            'genotype' => Yii::t('app', 'Genotype'),
            'pmid' => Yii::t('app', 'Pmid'),
            'gene_intervention_method_id' => Yii::t('app', 'Gene Intervention Method ID'),
        ];
    }

    /**
     * Gets query for [[GeneInterventionMethod]].
     *
     * @return \yii\db\ActiveQuery|GeneInterventionMethodQuery
     */
    public function getGeneInterventionMethod()
    {
        return $this->hasOne(GeneInterventionMethod::class, ['id' => 'gene_intervention_method_id']);
    }

    /**
     * Gets query for [[Gene]].
     *
     * @return \yii\db\ActiveQuery|GeneQuery
     */
    public function getGene()
    {
        return $this->hasOne(Gene::class, ['id' => 'gene_id']);
    }

    /**
     * Gets query for [[InterventionResultForVitalProcess]].
     *
     * @return \yii\db\ActiveQuery|InterventionResultForVitalProcessQuery
     */
    public function getInterventionResultForVitalProcess()
    {
        return $this->hasOne(InterventionResultForVitalProcess::class, ['id' => 'intervention_result_for_vital_process_id']);
    }

    /**
     * Gets query for [[GeneIntervention]].
     *
     * @return \yii\db\ActiveQuery|GeneInterventionQuery
     */
    public function getGeneIntervention()
    {
        return $this->hasOne(GeneIntervention::class, ['id' => 'gene_intervention_id']);
    }

    /**
     * Gets query for [[ModelOrganism]].
     *
     * @return \yii\db\ActiveQuery|ModelOrganismQuery
     */
    public function getModelOrganism()
    {
        return $this->hasOne(ModelOrganism::class, ['id' => 'model_organism_id']);
    }

    /**
     * Gets query for [[OrganismLine]].
     *
     * @return \yii\db\ActiveQuery|OrganismLineQuery
     */
    public function getOrganismLine()
    {
        return $this->hasOne(OrganismLine::class, ['id' => 'organism_line_id']);
    }

    /**
     * Gets query for [[VitalProcess]].
     *
     * @return \yii\db\ActiveQuery|VitalProcessQuery
     */
    public function getVitalProcess()
    {
        return $this->hasOne(VitalProcess::class, ['id' => 'vital_process_id']);
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
