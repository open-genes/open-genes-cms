<?php

namespace app\models\common;

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
class Ethnicity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ethnicity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_ru', 'name_en'], 'string', 'max' => 255],
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
     * @return \yii\db\ActiveQuery|GeneToLongevityEffectQuery
     */
    public function getGeneToLongevityEffects()
    {
        return $this->hasMany(GeneToLongevityEffect::class, ['ethnicity_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return EthnicityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EthnicityQuery(get_called_class());
    }
}
