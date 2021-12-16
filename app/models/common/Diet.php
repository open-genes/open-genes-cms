<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "diet".
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ru
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property GeneralLifespanExperiment[] $generalLifespanExperiments
 */
class Diet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'diet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['name_en', 'name_ru'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_en' => 'Name En',
            'name_ru' => 'Name Ru',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[GeneralLifespanExperiments]].
     *
     * @return \yii\db\ActiveQuery|GeneralLifespanExperimentQuery
     */
    public function getGeneralLifespanExperiments()
    {
        return $this->hasMany(GeneralLifespanExperiment::class, ['diet_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return DietQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DietQuery(get_called_class());
    }
}
