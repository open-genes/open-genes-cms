<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
use Yii;

/**
 * This is the model class for table "position".
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ru
 *
 * @property GeneToLongevityEffect[] $geneToLongevityEffects
 */
class Position extends \app\models\common\Position
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
                    'name_ru' => 'Name Ru',
                ];
    }


    /**
    * Gets query for [[GeneToLongevityEffects]].
    *
    * @return \yii\db\ActiveQuery|\app\models\common\GeneToLongevityEffectQuery
    */
    public function getGeneToLongevityEffects()
    {
    return $this->hasMany(GeneToLongevityEffect::class, ['position_id' => 'id']);
    }

    public function getLinkedGenesIds()
    {
        return []; // todo implement for column with related genes
    }

}
