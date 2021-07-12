<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "age".
 *
 */
class ProgeriaSyndrome extends common\ProgeriaSyndrome
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

    public function getLinkedGenesIds()
    {
        return $this->getGeneToProgerias()
            ->select('gene_id')->distinct()->column();
    }


}
