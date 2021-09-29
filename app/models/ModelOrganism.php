<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "age".
 *
 */
class ModelOrganism extends common\ModelOrganism
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
        return array_unique(array_merge(
            $this->getLifespanExperiments()
                ->select('gene_id')->distinct()->column(),
            $this->getGeneInterventionToVitalProcesses()
                ->select('gene_id')->distinct()->column(),
            $this->getAgeRelatedChanges()
                ->select('gene_id')->distinct()->column()
        ));
    }

    public static function getIdName()
    {
        return ArrayHelper::map(self::find()->all(),'id','name_ru');
    }
}
