<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
use Yii;

/**
 * This is the model class for table "active_substance".
 *
 * @property int $id
 * @property string|null $name_ru
 * @property string|null $name_en
 *
 * @property LifespanExperiment[] $lifespanExperiments
 */
class ActiveSubstance extends \app\models\common\ActiveSubstance
{
    use RuEnActiveRecordTrait;

    public $name;

    /**
    * {@inheritdoc}
    */
    public function behaviors()
    {
        return [
            ChangelogBehavior::class
        ];
    }

    /**
    * {@inheritdoc}
    */
    public function attributeLabels()
    {
        return [
                    'id' => Yii::t('app', 'ID'),
                    'name_ru' => Yii::t('app', 'Name Ru'),
                    'name_en' => Yii::t('app', 'Name En'),
                ];
    }


    /**
    * Gets query for [[LifespanExperiments]].
    *
    * @return \yii\db\ActiveQuery|\app\models\common\LifespanExperimentQuery
    */
    public function getLifespanExperiments()
    {
    return $this->hasMany(LifespanExperiment::class, ['active_substance_id' => 'id']);
    }

    public function getLinkedGenesIds()
    {
        return $this->getLifespanExperiments()
            ->select('gene_id')->distinct()->column();
    }

}
