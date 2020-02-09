<?php

namespace cms\models;

use cms\models\behaviors\ChangelogBehavior;
use cms\models\traits\RuEnActiveRecordTrait;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "age".
 *
 */
class VitalProcess extends \common\models\VitalProcess
{
    use RuEnActiveRecordTrait;

    public $name;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            ChangelogBehavior::class
        ];
    }


}
