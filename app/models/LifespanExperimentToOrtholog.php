<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
use Yii;

/**
 * This is the model class for table "lifespan_experiment_to_ortholog".
 *
 * @property int $id
 * @property int|null $lifespan_experiment_id
 * @property int|null $ortholog_id
 *
 * @property LifespanExperiment $lifespanExperiment
 * @property Ortholog $ortholog
 */
class LifespanExperimentToOrtholog extends common\LifespanExperimentToOrtholog
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
                    'lifespan_experiment_id' => 'Lifespan Experiment ID',
                    'ortholog_id' => 'Ortholog ID',
                ];
    }


    /**
    * Gets query for [[LifespanExperiment]].
    *
    * @return \yii\db\ActiveQuery|\app\models\common\LifespanExperimentQuery
    */
    public function getLifespanExperiment()
    {
    return $this->hasOne(LifespanExperiment::class, ['id' => 'lifespan_experiment_id']);
    }

    /**
    * Gets query for [[Ortholog]].
    *
    * @return \yii\db\ActiveQuery|\app\models\common\OrthologQuery
    */
    public function getOrtholog()
    {
    return $this->hasOne(Ortholog::class, ['id' => 'ortholog_id']);
    }

    public function getLinkedGenesIds()
    {
        return []; // todo implement for column with related genes
    }

    public static function getOrthologByName($name) {
        return self::find()->select('ortholog_id')
            ->where(['symbol' => $name])->one();
    }
}
