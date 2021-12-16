<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
use Yii;
use yii\behaviors\TimestampBehavior;

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
class Diet extends \app\models\common\Diet
{
    use RuEnActiveRecordTrait;

    public $name;

    /**
    * {@inheritdoc}
    */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            ChangelogBehavior::class
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
    * @return \yii\db\ActiveQuery
    */
    public function getGeneralLifespanExperiments()
    {
    return $this->hasMany(GeneralLifespanExperiment::class, ['diet_id' => 'id']);
    }

    public function getLinkedGenesIds()
    {
        return []; // todo implement for column with related genes
    }

}
