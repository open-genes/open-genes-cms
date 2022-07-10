<?php

namespace app\models\common;

class PhysicalActivity extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'physical_activity';
    }

    public function rules()
    {
        return [
            [['gene_id', 'tissue_id', 'measurement_method_id', 'expression_evaluation_id', 'model_organism_id', 'organism_line_id', 'organism_sex_id', 'created_at', 'updated_at'], 'integer'],
            [['p_value', 'after_sport_result', 'time_point', 'training_regimen', 'sportsman', 'age', 'age_units', 'experiment_groups_quantity', 'link', 'expression_change_log'], 'string', 'max' => 255],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::class, 'targetAttribute' => ['gene_id' => 'id']],
            [['tissue_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sample::class, 'targetAttribute' => ['tissue_id' => 'id']],
            [['measurement_method_id'], 'exist', 'skipOnError' => true, 'targetClass' => MeasurementMethod::class, 'targetAttribute' => ['measurement_method_id' => 'id']],
            [['expression_evaluation_id'], 'exist', 'skipOnError' => true, 'targetClass' => ExpressionEvaluation::class, 'targetAttribute' => ['expression_evaluation_id' => 'id']],
            [['model_organism_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModelOrganism::class, 'targetAttribute' => ['model_organism_id' => 'id']],
            [['organism_line_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganismLine::class, 'targetAttribute' => ['organism_line_id' => 'id']],
            [['organism_sex_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganismSex::class, 'targetAttribute' => ['organism_sex_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gene_id' => 'Gene Id',
            'tissue_id' => 'Tissue Id',
            'measurement_method_id' => 'Measurement Method Id',
            'expression_evaluation_id' => 'Expression Evaluation Id',
            'model_organism_id' => 'Model Organism Id',
            'organism_line_id' => 'Organism Line Id',
            'organism_sex_id' => 'Organism Sex Id',
            'p_value' => 'P_value',
            'after_sport_result' => 'After Sport Result',
            'time_point' => 'Time Point',
            'training_regimen' => 'Training Regimen',
            'sportsman' => 'Sportsman',
            'age' => 'Age',
            'age_units' => 'Age Units',
            'experiment_groups_quantity' => 'Experiment Groups Quantity',
            'link' => 'Link',
            'expression_change_log' => 'Expression Change Log',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function find()
    {
        return new PhysicalActivityQuery(get_called_class());
    }

    public function getGene()
    {
        return $this->hasOne(Gene::class, ['gene_id' => 'id']);
    }

    public function getSample()
    {
        return $this->hasOne(Sample::class, ['tissue_id' => 'id']);
    }

    public function getMeasurementMethod()
    {
        return $this->hasOne(MeasurementMethod::class, ['measurement_method_id' => 'id']);
    }

    public function getExpressionEvaluation()
    {
        return $this->hasOne(ExpressionEvaluation::class, ['expression_evaluation_id' => 'id']);
    }

    public function getModelOrganism()
    {
        return $this->hasOne(ModelOrganism::class, ['model_organism_id' => 'id']);
    }

    public function getOrganismLine()
    {
        return $this->hasOne(OrganismLine::class, ['organism_line_id' => 'id']);
    }

    public function getOrganismSex()
    {
        return $this->hasOne(OrganismSex::class, ['organism_sex_id' => 'id']);
    }
}