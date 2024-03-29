<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "polymorphism".
 *
 * @property int $id
 * @property string|null $name_ru
 * @property string|null $name_en
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property GeneToLongevityEffect[] $geneToLongevityEffects
 */
class Polymorphism extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'polymorphism';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[GeneToLongevityEffects]].
     *
     * @return \yii\db\ActiveQuery|GeneToLongevityEffectQuery
     */
    public function getGeneToLongevityEffects()
    {
        return $this->hasMany(GeneToLongevityEffect::class, ['polymorphism_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PolymorphismQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PolymorphismQuery(get_called_class());
    }
}
