<?php

namespace app\models\common;

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
class LifespanExperimentToOrtholog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lifespan_experiment_to_ortholog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lifespan_experiment_id', 'ortholog_id'], 'integer'],
            [['lifespan_experiment_id'], 'exist', 'skipOnError' => true, 'targetClass' => LifespanExperiment::class, 'targetAttribute' => ['lifespan_experiment_id' => 'id']],
            [['ortholog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ortholog::class, 'targetAttribute' => ['ortholog_id' => 'id']],
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
     * @return \yii\db\ActiveQuery|LifespanExperimentQuery
     */
    public function getLifespanExperiment()
    {
        return $this->hasOne(LifespanExperiment::class, ['id' => 'lifespan_experiment_id']);
    }

    /**
     * Gets query for [[Ortholog]].
     *
     * @return \yii\db\ActiveQuery|OrthologQuery
     */
    public function getOrtholog()
    {
        return $this->hasOne(Ortholog::class, ['id' => 'ortholog_id']);
    }

    /**
     * {@inheritdoc}
     * @return LifespanExperimentToOrthologQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LifespanExperimentToOrthologQuery(get_called_class());
    }
}
