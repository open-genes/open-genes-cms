<?php

namespace app\models\common;

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
class LifespanExperimentToTissue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lifespan_experiment_to_tissue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lifespan_experiment_id', 'tissue_id'], 'integer'],
            [['lifespan_experiment_id'], 'exist', 'skipOnError' => true, 'targetClass' => LifespanExperiment::class, 'targetAttribute' => ['lifespan_experiment_id' => 'id']],
            [['tissue_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sample::class, 'targetAttribute' => ['tissue_id' => 'id']],
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
     * @return \yii\db\ActiveQuery|LifespanExperimentQuery
     */
    public function getLifespanExperiment()
    {
        return $this->hasOne(LifespanExperiment::class, ['id' => 'lifespan_experiment_id']);
    }

    /**
     * Gets query for [[Tissue]].
     *
     * @return \yii\db\ActiveQuery|SampleQuery
     */
    public function getTissue()
    {
        return $this->hasOne(Sample::class, ['id' => 'tissue_id']);
    }

    /**
     * {@inheritdoc}
     * @return LifespanExperimentToTissueQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LifespanExperimentToTissueQuery(get_called_class());
    }
}
