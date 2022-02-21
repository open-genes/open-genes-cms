<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
use Yii;

/**
 * This is the model class for table "treatment_stage_of_development".
 *
 * @property int $id
 * @property string|null $name_ru
 * @property string|null $name_en
 *
 * @property LifespanExperiment[] $lifespanExperiments
 * @property LifespanExperiment[] $lifespanExperiments0
 */
class TreatmentStageOfDevelopment extends \app\models\common\TreatmentStageOfDevelopment
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
                    'id' => Yii::t('app', 'ID'),
                    'name_ru' => Yii::t('app', 'Name Ru'),
                    'name_en' => Yii::t('app', 'Name En'),
                ];
    }


    /**
    * Gets query for [[LifespanExperiments]].
    *
    * @return \yii\db\ActiveQuery|\app\models\common\LifespanExperimentQuery
    */
    public function getLifespanExperiments()
    {
    return $this->hasMany(LifespanExperiment::class, ['treatment_end_stage_of_development_id' => 'id']);
    }

    /**
    * Gets query for [[LifespanExperiments0]].
    *
    * @return \yii\db\ActiveQuery|\app\models\common\LifespanExperimentQuery
    */
    public function getLifespanExperiments0()
    {
    return $this->hasMany(LifespanExperiment::class, ['treatment_start_stage_of_development_id' => 'id']);
    }

    public function getLinkedGenesIdsStart()
    {
        return $this->getLifespanExperiments0()
            ->select('gene_id')->distinct()->column();
    }

}
