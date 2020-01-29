<?php

namespace common\models;

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
            [['gene_id', 'regulated_gene_id', 'protein_activity_id'], 'integer'],
            [['comment_en', 'comment_ru'], 'string'],
            [['reference'], 'string', 'max' => 255],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::className(), 'targetAttribute' => ['gene_id' => 'id']],
            [['protein_activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProteinActivity::className(), 'targetAttribute' => ['protein_activity_id' => 'id']],
            [['regulated_gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::className(), 'targetAttribute' => ['regulated_gene_id' => 'id']],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGene()
    {
        return $this->hasOne(Gene::className(), ['id' => 'gene_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProteinActivity()
    {
        return $this->hasOne(ProteinActivity::className(), ['id' => 'protein_activity_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegulatedGene()
    {
        return $this->hasOne(Gene::className(), ['id' => 'regulated_gene_id']);
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
