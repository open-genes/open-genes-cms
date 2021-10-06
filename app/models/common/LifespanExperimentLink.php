<?php

namespace app\models\common;

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
class LifespanExperimentLink extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lifespan_experiment_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lifespan_experiment_from_id', 'lifespan_experiment_to_id'], 'integer'],
            [['lifespan_experiment_from_id'], 'exist', 'skipOnError' => true, 'targetClass' => LifespanExperiment::class, 'targetAttribute' => ['lifespan_experiment_from_id' => 'id']],
            [['lifespan_experiment_to_id'], 'exist', 'skipOnError' => true, 'targetClass' => LifespanExperiment::class, 'targetAttribute' => ['lifespan_experiment_to_id' => 'id']],
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
     * @return \yii\db\ActiveQuery|LifespanExperimentQuery
     */
    public function getLifespanExperimentFrom()
    {
        return $this->hasOne(LifespanExperiment::class, ['id' => 'lifespan_experiment_from_id']);
    }

    /**
     * Gets query for [[LifespanExperimentTo]].
     *
     * @return \yii\db\ActiveQuery|LifespanExperimentQuery
     */
    public function getLifespanExperimentTo()
    {
        return $this->hasOne(LifespanExperiment::class, ['id' => 'lifespan_experiment_to_id']);
    }

    /**
     * {@inheritdoc}
     * @return LifespanExperimentLinkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LifespanExperimentLinkQuery(get_called_class());
    }
}
