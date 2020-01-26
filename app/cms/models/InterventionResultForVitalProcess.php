<?php

namespace cms\models;

use cms\models\traits\RuEnActiveRecordTrait;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "age".
 *
 */
class InterventionResultForVitalProcess extends \common\models\InterventionResultForVitalProcess
{
    use RuEnActiveRecordTrait;

    public $name;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }


}
