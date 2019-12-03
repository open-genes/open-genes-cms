<?php

namespace cms\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "age".
 *
 */
class ProcessLocalization extends \common\models\ProcessLocalization
{
    public $name;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }


    public static function getAllNamesAsArray()
    {
        $result = self::find()
            ->select(['id', 'concat(name_ru, \' \', \'(\', name_en, \')\') as name'])
            ->all();
        return ArrayHelper::map($result, 'id', 'name');
    }
}
