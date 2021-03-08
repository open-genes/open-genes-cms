<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "protein_class".
 *
 * @property int $id
 * @property string $name_en
 * @property string $name_ru
 * @property int $parent_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Gene[] $genes
 */
class ProteinClass extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'protein_class';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'created_at', 'updated_at'], 'integer'],
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
            'parent_id' => 'Parent ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenes()
    {
        return $this->hasMany(Gene::class, ['protein_class_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ProteinClassQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProteinClassQuery(get_called_class());
    }
}
