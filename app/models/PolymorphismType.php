<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
use Yii;

/**
 * This is the model class for table "polymorphism_type".
 *
 * @property int $id
 * @property string|null $name_en
 *
 * @property GeneToLongevityEffect[] $geneToLongevityEffects
 */
class PolymorphismType extends \app\models\common\PolymorphismType
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
                    'name_en' => 'Name En',
                ];
    }


    /**
    * Gets query for [[GeneToLongevityEffects]].
    *
    * @return \yii\db\ActiveQuery|\app\models\common\GeneToLongevityEffectQuery
    */
    public function getGeneToLongevityEffects()
    {
    return $this->hasMany(GeneToLongevityEffect::class, ['polymorphism_type_id' => 'id']);
    }

    public function getLinkedGenesIds()
    {
        return $this->getGeneToLongevityEffects()
            ->select('gene_id')->distinct()->column();
    }

    public static function getAllNamesAsArray()
    {
        $names = self::find()
            ->select(['id', 'name_en'])
            ->asArray()
            ->all();
        $result = [];
        foreach ($names as $name) {
            $result[$name['id']] = "{$name['name_en']}";
        }
        return $result;
    }
}
