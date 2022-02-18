<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
use Yii;

/**
 * This is the model class for table "organism_sex".
 *
 * @property int $id
 * @property int|null $name_ru
 * @property int|null $name_en
 *
 * @property LifespanExperiment[] $lifespanExperiments
 */
class OrganismSex extends \app\models\common\OrganismSex
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
    * Gets query for [[GeneralLifespanExperiments]].
    *
    * @return \yii\db\ActiveQuery|\app\models\common\GeneralLifespanExperimentQuery
    */
    public function getGeneralLifespanExperiments()
    {
    return $this->hasMany(GeneralLifespanExperiment::class, ['organism_sex_id' => 'id']);
    }

    /**
     * Gets query for [[LifespanExperiments]].
     *
     * @return \yii\db\ActiveQuery|\app\models\common\LifespanExperimentQuery
     */
    public function getLifespanExperiments()
    {
        return $this->hasMany(LifespanExperiment::class, ['general_lifespan_experiment_id' => 'id'])
            ->viaTable('general_lifespan_experiment', ['organism_sex_id' => 'id']);
    }

    public function getLinkedGenesIds()
    {
        return $this->getLifespanExperiments()
            ->select('gene_id')->distinct()->column();
    }

}
