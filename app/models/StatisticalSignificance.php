<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
use Yii;

/**
 * This is the model class for table "statistical_significance".
 *
 * @property int $id
 * @property int|null $name_ru
 * @property int|null $name_en
 *
 * @property LifespanExperiment[] $lifespanExperiments
 * @property LifespanExperiment[] $lifespanExperiments0
 * @property LifespanExperiment[] $lifespanExperiments1
 * @property LifespanExperiment[] $lifespanExperiments2
 */
class StatisticalSignificance extends \app\models\common\StatisticalSignificance
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
    return $this->hasMany(LifespanExperiment::class, ['lifespan_max_change_stat_sign_id' => 'id']);
    }

    /**
    * Gets query for [[LifespanExperiments0]].
    *
    * @return \yii\db\ActiveQuery|\app\models\common\LifespanExperimentQuery
    */
    public function getLifespanExperiments0()
    {
    return $this->hasMany(LifespanExperiment::class, ['lifespan_mean_change_stat_sign_id' => 'id']);
    }

    /**
    * Gets query for [[LifespanExperiments1]].
    *
    * @return \yii\db\ActiveQuery|\app\models\common\LifespanExperimentQuery
    */
    public function getLifespanExperiments1()
    {
    return $this->hasMany(LifespanExperiment::class, ['lifespan_median_change_stat_sign_id' => 'id']);
    }

    /**
    * Gets query for [[LifespanExperiments2]].
    *
    * @return \yii\db\ActiveQuery|\app\models\common\LifespanExperimentQuery
    */
    public function getLifespanExperiments2()
    {
    return $this->hasMany(LifespanExperiment::class, ['lifespan_min_change_stat_sign_id' => 'id']);
    }

    public function getLinkedGenesIds()
    {
        return []; // todo implement for column with related genes
    }

}
