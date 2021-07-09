<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "protein_class".
 *
 * @property int $id
 * @property string|null $name_en
 * @property string|null $name_ru
 * @property int|null $parent_id
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property GeneToProteinClass[] $geneToProteinClasses
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
     * Gets query for [[GeneToProteinClasses]].
     *
     * @return \yii\db\ActiveQuery|GeneToProteinClassQuery
     */
    public function getGeneToProteinClasses()
    {
        return $this->hasMany(GeneToProteinClass::className(), ['protein_class_id' => 'id']);
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
