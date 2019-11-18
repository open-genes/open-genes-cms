<?php

namespace cms\models;

use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 */
class GeneToFunctionRelationType extends \common\models\GeneToFunctionRelationType
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