<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "age_related_change".
 *
 * @property int $id
 * @property int|null $gene_id
 * @property int|null $age_related_change_type_id
 * @property int|null $sample_id
 * @property int|null $model_organism_id
 * @property int|null $organism_line_id
 * @property float|null $mean_age_of_controls
 * @property float|null $mean_age_of_experiment
 * @property float|null $min_age_of_controls
 * @property float|null $max_age_of_controls
 * @property float|null $min_age_of_experiment
 * @property float|null $max_age_of_experiment
 * @property float|null $n_of_controls
 * @property float|null $n_of_experiment
 * @property string|null $reference
 * @property string|null $comment_en
 * @property string|null $comment_ru
 * @property float|null $change_value
 * @property int|null $age_unit_id
 * @property int|null $measurement_method_id
 * @property int|null $expression_evaluation_by_id
 * @property int|null $sex
 * @property int|null $statistical_method_id
 * @property string|null $p_value
 * @property string|null $pmid
 *
 * @property Gene $gene
 * @property ModelOrganism $modelOrganism
 * @property OrganismLine $organismLine
 * @property Sample $sample
 * @property AgeRelatedChangeType $ageRelatedChangeType
 */
class AgeRelatedChange extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'age_related_change';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gene_id', 'age_related_change_type_id', 'sample_id', 'model_organism_id', 'organism_line_id', 'age_unit_id', 'measurement_method_id', 'expression_evaluation_by_id', 'statistical_method_id'], 'integer'],
            [['mean_age_of_controls', 'mean_age_of_experiment', 'min_age_of_controls', 'max_age_of_controls', 'min_age_of_experiment', 'max_age_of_experiment', 'change_value', 'n_of_controls', 'n_of_experiment'], 'number'],
            [['comment_en', 'comment_ru', 'p_value'], 'string'],
            [['reference', 'pmid'], 'string', 'max' => 255],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::className(), 'targetAttribute' => ['gene_id' => 'id']],
            [['model_organism_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModelOrganism::className(), 'targetAttribute' => ['model_organism_id' => 'id']],
            [['organism_line_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganismLine::className(), 'targetAttribute' => ['organism_line_id' => 'id']],
            [['sample_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sample::className(), 'targetAttribute' => ['sample_id' => 'id']],
            [['age_related_change_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => AgeRelatedChangeType::className(), 'targetAttribute' => ['age_related_change_type_id' => 'id']],
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
            'age_related_change_type_id' => 'Age Related Change Type ID',
            'sample_id' => 'Sample ID',
            'model_organism_id' => 'Model Organism ID',
            'organism_line_id' => 'Organism Line ID',
            'mean_age_of_controls' => 'Mean Age Of Controls',
            'mean_age_of_experiment' => 'Mean Age Of Experiment',
            'min_age_of_controls' => 'Min Age Of Controls',
            'max_age_of_controls' => 'Max Age Of Controls',
            'min_age_of_experiment' => 'Min Age Of Experiment',
            'max_age_of_experiment' => 'Max Age Of Experiment',
            'reference' => 'Reference',
            'comment_en' => 'Comment En',
            'comment_ru' => 'Comment Ru',
            'change_value' => 'Change Value',
            'age_unit_id' => 'Age Unit',
            'measurement_method_id' => 'Measurement Method',
            'expression_evaluation_by_id' => 'Expression Evaluation by',
            'statistical_method_id' => 'Statistical Method',
            'p_value' => 'P - value',
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
        return $this->hasOne(Gene::class, ['id' => 'gene_id']);
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
     * Gets query for [[Sample]].
     *
     * @return \yii\db\ActiveQuery|SampleQuery
     */
    public function getSample()
    {
        return $this->hasOne(Sample::class, ['id' => 'sample_id']);
    }

    /**
     * Gets query for [[AgeRelatedChangeType]].
     *
     * @return \yii\db\ActiveQuery|AgeRelatedChangeTypeQuery
     */
    public function getAgeRelatedChangeType()
    {
        return $this->hasOne(AgeRelatedChangeType::class, ['id' => 'age_related_change_type_id']);
    }

    /**
     * {@inheritdoc}
     * @return AgeRelatedChangeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AgeRelatedChangeQuery(get_called_class());
    }
}
