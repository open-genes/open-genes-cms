<?php

namespace cms\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "age".
 *
 */
class Age extends \common\models\Age
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
        $ages = self::find()->all();
        foreach ($ages as $age) {
            $result[$age->id] = $age->name_phylo;
        }

        return $result;
    }
}
