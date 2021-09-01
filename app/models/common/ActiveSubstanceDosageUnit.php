<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "active_substance_dosage_unit".
 *
 * @property int $id
 * @property string|null $name_ru
 * @property string|null $name_en
 *
 * @property LifespanExperiment[] $lifespanExperiments
 */
class ActiveSubstanceDosageUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'active_substance_dosage_unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_ru', 'name_en'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name_ru' => Yii::t('app', 'Name Ru'),
            'name_en' => Yii::t('app', 'Name En'),
        ];
    }

    /**
     * Gets query for [[LifespanExperiments]].
     *
     * @return \yii\db\ActiveQuery|LifespanExperimentQuery
     */
    public function getLifespanExperiments()
    {
        return $this->hasMany(LifespanExperiment::class, ['active_substance_dosage_unit_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ActiveSubstanceDosageUnitQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActiveSubstanceDosageUnitQuery(get_called_class());
    }
}
