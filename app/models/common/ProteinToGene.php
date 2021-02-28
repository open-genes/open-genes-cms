<?php

namespace cms\models\common;

use Yii;

/**
 * This is the model class for table "protein_to_gene".
 *
 * @property int $id
 * @property int $gene_id
 * @property int $regulated_gene_id
 * @property int $protein_activity_id
 * @property string $reference
 * @property string $comment_en
 * @property string $comment_ru
 * @property int $regulation_type
 *
 * @property Gene $gene
 * @property ProteinActivity $proteinActivity
 * @property Gene $regulatedGene
 */
class ProteinToGene extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'protein_to_gene';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gene_id', 'regulated_gene_id', 'protein_activity_id', 'regulation_type'], 'integer'],
            [['comment_en', 'comment_ru'], 'string'],
            [['reference'], 'string', 'max' => 255],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::class, 'targetAttribute' => ['gene_id' => 'id']],
            [['protein_activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProteinActivity::class, 'targetAttribute' => ['protein_activity_id' => 'id']],
            [['regulated_gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::class, 'targetAttribute' => ['regulated_gene_id' => 'id']],
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
            'regulated_gene_id' => 'Regulated Gene ID',
            'protein_activity_id' => 'Protein Activity ID',
            'reference' => 'Reference',
            'comment_en' => 'Comment En',
            'comment_ru' => 'Comment Ru',
            'regulation_type' => 'Regulation Type',
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
    public function getProteinActivity()
    {
        return $this->hasOne(ProteinActivity::class, ['id' => 'protein_activity_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegulatedGene()
    {
        return $this->hasOne(Gene::class, ['id' => 'regulated_gene_id']);
    }

    /**
     * {@inheritdoc}
     * @return ProteinToGeneQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProteinToGeneQuery(get_called_class());
    }
}
