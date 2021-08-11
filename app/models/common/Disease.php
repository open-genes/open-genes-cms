<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "disease".
 *
 * @property int $id
 * @property int|null $omim_id
 * @property string|null $name_ru
 * @property string|null $name_en
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property string|null $icd_code
 * @property string|null $parent_icd_code
 * @property string|null $icd_name_en
 * @property string|null $icd_name_ru
 * @property string|null $icd_code_visible
 *
 * @property GeneToDisease[] $geneToDiseases
 */
class Disease extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'disease';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['omim_id', 'created_at', 'updated_at'], 'integer'],
            [['name_ru', 'name_en', 'icd_name_en', 'icd_name_ru'], 'string', 'max' => 255],
            [['icd_code', 'parent_icd_code', 'icd_code_visible'], 'string', 'max' => 128],
            [['omim_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'omim_id' => 'Omim ID',
            'name_ru' => 'Name Ru',
            'name_en' => 'Name En',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'icd_code' => 'Icd Code',
            'parent_icd_code' => 'Parent Icd Code',
            'icd_name_en' => 'Icd Name En',
            'icd_name_ru' => 'Icd Name Ru',
        ];
    }

    /**
     * Gets query for [[GeneToDiseases]].
     *
     * @return \yii\db\ActiveQuery|GeneToDiseaseQuery
     */
    public function getGeneToDiseases()
    {
        return $this->hasMany(GeneToDisease::className(), ['disease_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return DiseaseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DiseaseQuery(get_called_class());
    }
}
