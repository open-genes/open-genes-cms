<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "gene_to_additional_evidence".
 *
 * @property int $id
 * @property int|null $gene_id
 * @property string|null $reference
 * @property string|null $comment_ru
 * @property string|null $comment_en
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property string|null $pmid
 *
 * @property Gene $gene
 */
class GeneToAdditionalEvidence extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gene_to_additional_evidence';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gene_id', 'created_at', 'updated_at'], 'integer'],
            [['comment_ru', 'comment_en'], 'string'],
            [['reference', 'pmid'], 'string', 'max' => 255],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::className(), 'targetAttribute' => ['gene_id' => 'id']],
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
            'reference' => 'Reference',
            'comment_ru' => 'Comment Ru',
            'comment_en' => 'Comment En',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
     * {@inheritdoc}
     * @return GeneToAdditionalEvidenceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeneToAdditionalEvidenceQuery(get_called_class());
    }
}
