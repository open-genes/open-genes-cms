<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "age".
 *
 */
class VitalProcess extends common\VitalProcess
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
        return $this->getGeneInterventionToVitalProcesses()
            ->select('gene_id')->distinct()->column();
    }

    public static function getIdByName($name)
    {
        return self::find()->select('id')->where(
            [
                'or',
                ['name_ru' => $name],
                ['name_en' => $name],
            ]
        )->one();

    }
}
