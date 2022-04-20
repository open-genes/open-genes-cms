<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "polymorphism_type".
 *
 * @property int $id
 * @property string|null $name_en
 *
 * @property GeneToLongevityEffect[] $geneToLongevityEffects
 */
class PolymorphismType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'polymorphism_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_en'], 'string', 'max' => 255],
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
     * @return \yii\db\ActiveQuery|GeneToLongevityEffectQuery
     */
    public function getGeneToLongevityEffects()
    {
        return $this->hasMany(GeneToLongevityEffect::class, ['polymorphism_type_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PolymorphismTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PolymorphismTypeQuery(get_called_class());
    }
}
