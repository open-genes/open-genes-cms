<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "gene_regulation_type".
 *
 * @property int $id
 * @property string|null $name_ru
 * @property string|null $name_en
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property ProteinToGene[] $proteinToGenes
 */
class GeneRegulationType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gene_regulation_type';
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
     * Gets query for [[ProteinToGenes]].
     *
     * @return \yii\db\ActiveQuery|ProteinToGeneQuery
     */
    public function getProteinToGenes()
    {
        return $this->hasMany(ProteinToGene::className(), ['regulation_type_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return GeneRegulationTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeneRegulationTypeQuery(get_called_class());
    }
}
