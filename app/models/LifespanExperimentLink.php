<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
use Yii;

/**
 * This is the model class for table "lifespan_experiment_link".
 *
 * @property int $id
 * @property int|null $lifespan_experiment_from_id
 * @property int|null $lifespan_experiment_to_id
 *
 * @property LifespanExperiment $lifespanExperimentFrom
 * @property LifespanExperiment $lifespanExperimentTo
 */
class LifespanExperimentLink extends \app\models\common\LifespanExperimentLink
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
                    'lifespan_experiment_from_id' => Yii::t('app', 'Lifespan Experiment From ID'),
                    'lifespan_experiment_to_id' => Yii::t('app', 'Lifespan Experiment To ID'),
                ];
    }


    /**
    * Gets query for [[LifespanExperimentFrom]].
    *
    * @return \yii\db\ActiveQuery|\app\models\common\LifespanExperimentQuery
    */
    public function getLifespanExperimentFrom()
    {
    return $this->hasOne(LifespanExperiment::class, ['id' => 'lifespan_experiment_from_id']);
    }

    /**
    * Gets query for [[LifespanExperimentTo]].
    *
    * @return \yii\db\ActiveQuery|\app\models\common\LifespanExperimentQuery
    */
    public function getLifespanExperimentTo()
    {
    return $this->hasOne(LifespanExperiment::class, ['id' => 'lifespan_experiment_to_id']);
    }

    public function getLinkedGenesIds()
    {
        return []; // todo implement for column with related genes
    }

}
