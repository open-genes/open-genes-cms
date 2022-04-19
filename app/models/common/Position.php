<?php

namespace app\models\common;

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
class Position extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'position';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_en', 'name_ru'], 'string', 'max' => 255],
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
     * @return \yii\db\ActiveQuery|GeneToLongevityEffectQuery
     */
    public function getGeneToLongevityEffects()
    {
        return $this->hasMany(GeneToLongevityEffect::class, ['position_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PositionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PositionQuery(get_called_class());
    }
}
