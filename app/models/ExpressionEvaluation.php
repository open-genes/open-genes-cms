<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
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
class ExpressionEvaluation extends common\ExpressionEvaluation
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
                    'name_ru' => 'Name Ru',
                    'name_en' => 'Name En',
                ];
    }


    /**
    * Gets query for [[AgeRelatedChanges]].
    *
    * @return \yii\db\ActiveQuery|\app\models\common\AgeRelatedChangeQuery
    */
    public function getAgeRelatedChanges()
    {
    return $this->hasMany(AgeRelatedChange::class, ['expression_evaluation_by_id' => 'id']);
    }

    /**
    * Gets query for [[CalorieRestrictionExperiments]].
    *
    * @return \yii\db\ActiveQuery|\app\models\common\CalorieRestrictionExperimentQuery
    */
    public function getCalorieRestrictionExperiments()
    {
    return $this->hasMany(CalorieRestrictionExperiment::class, ['measurement_type_id' => 'id']);
    }

    /**
    * Gets query for [[GeneralLifespanExperiments]].
    *
    * @return \yii\db\ActiveQuery|\app\models\common\GeneralLifespanExperimentQuery
    */
    public function getGeneralLifespanExperiments()
    {
    return $this->hasMany(GeneralLifespanExperiment::class, ['expression_evaluation_by_id' => 'id']);
    }

    public function getLinkedGenesIds()
    {
        return $this->getAgeRelatedChanges()
            ->select('gene_id')->distinct()->column();
    }

}
