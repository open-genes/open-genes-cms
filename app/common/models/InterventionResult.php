<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "intervention_result".
 *
 * @property int $id
 * @property string $name_ru
 * @property string $name_en
 * @property int $created_at
 * @property int $updated_at
 *
 * @property LifespanExperiment[] $lifespanExperiments
 */
class InterventionResult extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'intervention_result';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['name_ru', 'name_en'], 'string', 'max' => 255],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLifespanExperiments()
    {
        return $this->hasMany(LifespanExperiment::className(), ['intervention_result_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return InterventionResultQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InterventionResultQuery(get_called_class());
    }
}
