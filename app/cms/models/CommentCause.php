<?php

namespace cms\models;

use cms\models\behaviors\ChangelogBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "age".
 *
 */
class CommentCause extends \common\models\CommentCause
{
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            ChangelogBehavior::class
        ];
    }

    public static function findAllAsArray()
    {
        $result = [];
        $functionalClusters = self::find()->all();
        foreach ($functionalClusters as $functionalCluster) {
            $result[$functionalCluster->id] = $functionalCluster->name_ru;
        }

        return $result;
    }
}
