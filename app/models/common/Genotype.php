<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "genotype".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property LifespanExperiment[] $lifespanExperiments
 */
class Genotype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'genotype';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_ru'], 'string', 'max' => 255],
            [['name_en'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * Gets query for [[LifespanExperiments]].
     *
     * @return \yii\db\ActiveQuery|LifespanExperimentQuery
     */
    public function getLifespanExperiments()
    {
        return $this->hasMany(LifespanExperiment::class, ['genotype' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return GenotypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GenotypeQuery(get_called_class());
    }
}
