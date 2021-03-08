<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "model_organism".
 *
 * @property int $id
 * @property string $name_ru
 * @property string $name_en
 * @property int $created_at
 * @property int $updated_at
 *
 * @property LifespanExperiment[] $lifespanExperiments
 */
class ModelOrganism extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'model_organism';
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
        return $this->hasMany(LifespanExperiment::className(), ['model_organism_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ModelOrganismQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ModelOrganismQuery(get_called_class());
    }
}
