<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
use Yii;

/**
 * This is the model class for table "measurement_type".
 *
 * @property int $id
 * @property string|null $name_ru
 * @property string|null $name_en
 *
 * @property AgeRelatedChange[] $ageRelatedChanges
 */
class MeasurementType extends common\MeasurementType
{
    use RuEnActiveRecordTrait;

    public $name;

    /**
    * {@inheritdoc}
    */
    public function behaviors()
    {
        return [
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
                    'name_ru' => 'Name Ru',
                    'name_en' => 'Name En',
                ];
    }


    /**
    * Gets query for [[AgeRelatedChanges]].
    *
    * @return \yii\db\ActiveQuery|\app\models\common\AgeRelatedChangeQuery
    */
    public function getAgeRelatedChanges()
    {
    return $this->hasMany(AgeRelatedChange::class, ['measurement_type_id' => 'id']);
    }

    public function getLinkedGenesIds()
    {
        return []; // todo implement for column with related genes
    }

}
