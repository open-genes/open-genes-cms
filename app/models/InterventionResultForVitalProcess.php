<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "age".
 *
 */
class InterventionResultForVitalProcess extends common\InterventionResultForVitalProcess
{
    use RuEnActiveRecordTrait;

    public $name;
    public const IMPROVEMENT_ID = 1;
    public const DETERIORATION_ID = 2;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            ChangelogBehavior::class
        ];
    }

    public function getLinkedGenesIds()
    {
        return $this->getGeneInterventionToVitalProcesses()
            ->select('gene_id')->distinct()->column();
    }


}
