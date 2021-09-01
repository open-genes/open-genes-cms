<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
use Yii;

/**
 * This is the model class for table "lifespan_experiment_to_tissue".
 *
 * @property int $id
 * @property int|null $lifespan_experiment_id
 * @property int|null $tissue_id
 *
 * @property LifespanExperiment $lifespanExperiment
 * @property Sample $tissue
 */
class LifespanExperimentToTissue extends \app\models\common\LifespanExperimentToTissue
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
                    'lifespan_experiment_id' => Yii::t('app', 'Lifespan Experiment ID'),
                    'tissue_id' => Yii::t('app', 'Tissue ID'),
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
    * Gets query for [[Tissue]].
    *
    * @return \yii\db\ActiveQuery|\app\models\common\SampleQuery
    */
    public function getTissue()
    {
    return $this->hasOne(Sample::class, ['id' => 'tissue_id']);
    }

    public function getLinkedGenesIds()
    {
        return []; // todo implement for column with related genes
    }

}
