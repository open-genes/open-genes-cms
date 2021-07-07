<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "lifespan_experiment".
 *
 * @property int $id
 * @property int|null $gene_id
 * @property int|null $gene_intervention_id
 * @property int|null $intervention_result_id
 * @property int|null $model_organism_id
 * @property float|null $age
 * @property string|null $reference
 * @property string|null $comment_en
 * @property string|null $comment_ru
 * @property int|null $sex
 * @property int|null $organism_line_id
 * @property float|null $lifespan_change_percent_male
 * @property float|null $lifespan_change_percent_female
 * @property float|null $lifespan_change_percent_common
 * @property int|null $age_unit
 * @property int|null $genotype
 * @property string|null $pmid
 *
 * @property Gene $gene
 * @property GeneIntervention $geneIntervention
 * @property InterventionResultForLongevity $interventionResult
 * @property ModelOrganism $modelOrganism
 * @property OrganismLine $organismLine
 */
class LifespanExperiment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lifespan_experiment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gene_id', 'gene_intervention_id', 'intervention_result_id', 'model_organism_id', 'sex', 'organism_line_id', 'age_unit', 'genotype'], 'integer'],
            [['age', 'lifespan_change_percent_male', 'lifespan_change_percent_female', 'lifespan_change_percent_common'], 'number'],
            [['comment_en', 'comment_ru'], 'string'],
            [['reference', 'pmid'], 'string', 'max' => 255],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::className(), 'targetAttribute' => ['gene_id' => 'id']],
            [['gene_intervention_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeneIntervention::className(), 'targetAttribute' => ['gene_intervention_id' => 'id']],
            [['intervention_result_id'], 'exist', 'skipOnError' => true, 'targetClass' => InterventionResultForLongevity::className(), 'targetAttribute' => ['intervention_result_id' => 'id']],
            [['model_organism_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModelOrganism::className(), 'targetAttribute' => ['model_organism_id' => 'id']],
            [['organism_line_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganismLine::className(), 'targetAttribute' => ['organism_line_id' => 'id']],
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
            'intervention_result_id' => 'Intervention Result ID',
            'model_organism_id' => 'Model Organism ID',
            'age' => 'Age',
            'reference' => 'Reference',
            'comment_en' => 'Comment En',
            'comment_ru' => 'Comment Ru',
            'sex' => 'Sex',
            'organism_line_id' => 'Organism Line ID',
            'lifespan_change_percent_male' => 'Lifespan Change Percent Male',
            'lifespan_change_percent_female' => 'Lifespan Change Percent Female',
            'lifespan_change_percent_common' => 'Lifespan Change Percent Common',
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
     * Gets query for [[GeneIntervention]].
     *
     * @return \yii\db\ActiveQuery|GeneInterventionQuery
     */
    public function getGeneIntervention()
    {
        return $this->hasOne(GeneIntervention::className(), ['id' => 'gene_intervention_id']);
    }

    /**
     * Gets query for [[InterventionResult]].
     *
     * @return \yii\db\ActiveQuery|InterventionResultForLongevityQuery
     */
    public function getInterventionResult()
    {
        return $this->hasOne(InterventionResultForLongevity::className(), ['id' => 'intervention_result_id']);
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
     * {@inheritdoc}
     * @return LifespanExperimentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LifespanExperimentQuery(get_called_class());
    }
}
