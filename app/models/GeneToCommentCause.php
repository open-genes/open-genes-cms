<?php

namespace cms\models;

use cms\models\behaviors\ChangelogBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "age".
 *
 */
class GeneToCommentCause extends common\GeneToCommentCause
{


    public function behaviors()
    {
        return [
            ChangelogBehavior::class
        ];
    }
}
