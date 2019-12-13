<?php

namespace cms\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "age".
 *
 */
class ProteinClass extends \common\models\ProteinClass
{
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public static function findAllAsArray()
    {
        $result = [];
        $models = self::find()->all();
        foreach ($models as $model) {
            $result[$model->id] = $model->name_en;
        }

        return $result;
    }
}
