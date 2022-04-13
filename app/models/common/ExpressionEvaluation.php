<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "expression_evaluation".
 *
 * @property int $id
 * @property string|null $name_ru
 * @property string|null $name_en
 *
 * @property AgeRelatedChange[] $ageRelatedChanges
 * @property CalorieRestrictionExperiment[] $calorieRestrictionExperiments
 * @property GeneralLifespanExperiment[] $generalLifespanExperiments
 */
class ExpressionEvaluation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'expression_evaluation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_ru', 'name_en'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_ru' => 'Name Ru',
            'name_en' => 'Name En',
        ];
    }

    /**
     * Gets query for [[AgeRelatedChanges]].
     *
     * @return \yii\db\ActiveQuery|AgeRelatedChangeQuery
     */
    public function getAgeRelatedChanges()
    {
        return $this->hasMany(AgeRelatedChange::class, ['expression_evaluation_by_id' => 'id']);
    }

    /**
     * Gets query for [[CalorieRestrictionExperiments]].
     *
     * @return \yii\db\ActiveQuery|CalorieRestrictionExperimentQuery
     */
    public function getCalorieRestrictionExperiments()
    {
        return $this->hasMany(CalorieRestrictionExperiment::class, ['measurement_method_id' => 'id']);
    }

    /**
     * Gets query for [[GeneralLifespanExperiments]].
     *
     * @return \yii\db\ActiveQuery|GeneralLifespanExperimentQuery
     */
    public function getGeneralLifespanExperiments()
    {
        return $this->hasMany(GeneralLifespanExperiment::class, ['expression_evaluation_by_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ExpressionEvaluationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ExpressionEvaluationQuery(get_called_class());
    }
}
