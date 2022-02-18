<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
use Yii;

/**
 * This is the model class for table "genotype".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property LifespanExperiment[] $lifespanExperiments
 */
class Genotype extends common\Genotype
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
                    'id' => 'ID',
                    'name_ru' => 'Name Ru',
                    'name_en' => 'Name En',
                ];
    }


    /**
    * Gets query for [[LifespanExperiments]].
    *
    * @return \yii\db\ActiveQuery|\app\models\common\LifespanExperimentQuery
    */
    public function getLifespanExperiments()
    {
    return $this->hasMany(LifespanExperiment::class, ['genotype' => 'id']);
    }

    public function getLinkedGenesIds()
    {
        return $this->getLifespanExperiments()
            ->select('gene_id')->distinct()->column();
    }

    public static function getAllNames()
    {
        $names = self::getAllNamesAsArray();
        $result = [];
        foreach ($names as $id => $name) {
            $result[$id] = strtok($name, '(');
        }
        return $result;

    }

}
