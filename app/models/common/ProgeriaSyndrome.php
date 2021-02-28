<?php

namespace cms\models\common;

use Yii;

/**
 * This is the model class for table "progeria_syndrome".
 *
 * @property int $id
 * @property string $name_ru
 * @property string $name_en
 * @property int $created_at
 * @property int $updated_at
 *
 * @property GeneToProgeria[] $geneToProgerias
 */
class ProgeriaSyndrome extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'progeria_syndrome';
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
     * @return \yii\db\ActiveQuery
     */
    public function getGeneToProgerias()
    {
        return $this->hasMany(GeneToProgeria::className(), ['progeria_syndrome_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ProgeriaSyndromeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProgeriaSyndromeQuery(get_called_class());
    }
}
