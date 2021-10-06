<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "organism_sex".
 *
 * @property int $id
 * @property int|null $name_ru
 * @property int|null $name_en
 *
 * @property LifespanExperiment[] $lifespanExperiments
 */
class OrganismSex extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organism_sex';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_ru', 'name_en'], 'integer'],
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
        return $this->hasMany(LifespanExperiment::class, ['organism_sex_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return OrganismSexQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrganismSexQuery(get_called_class());
    }
}
