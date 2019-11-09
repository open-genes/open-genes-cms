<?php

namespace cms\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "sample".
 *
 */
class Sample extends \common\models\Sample
{

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
