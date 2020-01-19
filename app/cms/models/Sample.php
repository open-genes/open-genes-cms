<?php

namespace cms\models;

use cms\models\traits\RuEnActiveRecordTrait;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "sample".
 *
 */
class Sample extends \common\models\Sample
{
    use RuEnActiveRecordTrait;

    public $name;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
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

}
