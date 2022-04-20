<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
use Yii;

/**
 * This is the model class for table "ethnicity".
 *
 * @property int $id
 * @property string|null $name_ru
 * @property string|null $name_en
 *
 * @property GeneToLongevityEffect[] $geneToLongevityEffects
 */
class Ethnicity extends \app\models\common\Ethnicity
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
    * Gets query for [[GeneToLongevityEffects]].
    *
    * @return \yii\db\ActiveQuery|\app\models\common\GeneToLongevityEffectQuery
    */
    public function getGeneToLongevityEffects()
    {
    return $this->hasMany(GeneToLongevityEffect::class, ['ethnicity_id' => 'id']);
    }

    public function getLinkedGenesIds()
    {
        return $this->getGeneToLongevityEffects()
            ->select('gene_id')->distinct()->column();
    }

}
