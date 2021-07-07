<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "protein_to_gene".
 *
 * @property int $id
 * @property int|null $gene_id
 * @property int|null $regulated_gene_id
 * @property int|null $protein_activity_id
 * @property string|null $reference
 * @property string|null $comment_en
 * @property string|null $comment_ru
 * @property int|null $regulation_type
 * @property int|null $regulation_type_id
 * @property string|null $pmid
 *
 * @property Gene $gene
 * @property ProteinActivity $proteinActivity
 * @property GeneRegulationType $regulationType
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
            [['gene_id', 'regulated_gene_id', 'protein_activity_id', 'regulation_type', 'regulation_type_id'], 'integer'],
            [['comment_en', 'comment_ru'], 'string'],
            [['reference', 'pmid'], 'string', 'max' => 255],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::className(), 'targetAttribute' => ['gene_id' => 'id']],
            [['protein_activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProteinActivity::className(), 'targetAttribute' => ['protein_activity_id' => 'id']],
            [['regulation_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeneRegulationType::className(), 'targetAttribute' => ['regulation_type_id' => 'id']],
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
            'regulation_type' => 'Regulation Type',
            'regulation_type_id' => 'Regulation Type ID',
            'pmid' => 'Pmid',
        ];
    }

    /**
     * Gets query for [[Gene]].
     *
     * @return \yii\db\ActiveQuery|GeneQuery
     */
    public function getGene()
    {
        return $this->hasOne(Gene::className(), ['id' => 'gene_id']);
    }

    /**
     * Gets query for [[ProteinActivity]].
     *
     * @return \yii\db\ActiveQuery|ProteinActivityQuery
     */
    public function getProteinActivity()
    {
        return $this->hasOne(ProteinActivity::className(), ['id' => 'protein_activity_id']);
    }

    /**
     * Gets query for [[RegulationType]].
     *
     * @return \yii\db\ActiveQuery|GeneRegulationTypeQuery
     */
    public function getRegulationType()
    {
        return $this->hasOne(GeneRegulationType::className(), ['id' => 'regulation_type_id']);
    }

    /**
     * Gets query for [[RegulatedGene]].
     *
     * @return \yii\db\ActiveQuery|GeneQuery
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
