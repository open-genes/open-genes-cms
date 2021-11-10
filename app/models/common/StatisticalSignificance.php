<?php

namespace app\models\common;

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
class StatisticalSignificance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'statistical_significance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_ru', 'name_en'], 'safe'],
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
     * @return \yii\db\ActiveQuery|LifespanExperimentQuery
     */
    public function getLifespanExperiments()
    {
        return $this->hasMany(LifespanExperiment::class, ['lifespan_max_change_stat_sign_id' => 'id']);
    }

    /**
     * Gets query for [[LifespanExperiments0]].
     *
     * @return \yii\db\ActiveQuery|LifespanExperimentQuery
     */
    public function getLifespanExperiments0()
    {
        return $this->hasMany(LifespanExperiment::class, ['lifespan_mean_change_stat_sign_id' => 'id']);
    }

    /**
     * Gets query for [[LifespanExperiments1]].
     *
     * @return \yii\db\ActiveQuery|LifespanExperimentQuery
     */
    public function getLifespanExperiments1()
    {
        return $this->hasMany(LifespanExperiment::class, ['lifespan_median_change_stat_sign_id' => 'id']);
    }

    /**
     * Gets query for [[LifespanExperiments2]].
     *
     * @return \yii\db\ActiveQuery|LifespanExperimentQuery
     */
    public function getLifespanExperiments2()
    {
        return $this->hasMany(LifespanExperiment::class, ['lifespan_min_change_stat_sign_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return StatisticalSignificanceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StatisticalSignificanceQuery(get_called_class());
    }
}
