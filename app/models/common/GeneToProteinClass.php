<?php

namespace cms\models\common;

use Yii;

/**
 * This is the model class for table "gene_to_protein_class".
 *
 * @property int $id
 * @property int $gene_id
 * @property int $protein_class_id
 *
 * @property Gene $gene
 * @property ProteinClass $proteinClass
 */
class GeneToProteinClass extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gene_to_protein_class';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gene_id', 'protein_class_id'], 'integer'],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::class, 'targetAttribute' => ['gene_id' => 'id']],
            [['protein_class_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProteinClass::class, 'targetAttribute' => ['protein_class_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gene_id' => 'Gene ID',
            'protein_class_id' => 'Protein Class ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGene()
    {
        return $this->hasOne(Gene::class, ['id' => 'gene_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProteinClass()
    {
        return $this->hasOne(ProteinClass::class, ['id' => 'protein_class_id']);
    }

    /**
     * {@inheritdoc}
     * @return GeneToProteinClassQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeneToProteinClassQuery(get_called_class());
    }
}
