<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "gene_to_progeria".
 *
 * @property int $id
 * @property int|null $gene_id
 * @property int|null $progeria_syndrome_id
 * @property string|null $reference
 * @property string|null $comment_en
 * @property string|null $comment_ru
 * @property string|null $pmid
 *
 * @property Gene $gene
 * @property ProgeriaSyndrome $progeriaSyndrome
 */
class GeneToProgeria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gene_to_progeria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gene_id', 'progeria_syndrome_id'], 'integer'],
            [['comment_en', 'comment_ru'], 'string'],
            [['reference', 'pmid'], 'string', 'max' => 255],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::className(), 'targetAttribute' => ['gene_id' => 'id']],
            [['progeria_syndrome_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProgeriaSyndrome::className(), 'targetAttribute' => ['progeria_syndrome_id' => 'id']],
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
            'progeria_syndrome_id' => 'Progeria Syndrome ID',
            'reference' => 'Reference',
            'comment_en' => 'Comment En',
            'comment_ru' => 'Comment Ru',
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
     * Gets query for [[ProgeriaSyndrome]].
     *
     * @return \yii\db\ActiveQuery|ProgeriaSyndromeQuery
     */
    public function getProgeriaSyndrome()
    {
        return $this->hasOne(ProgeriaSyndrome::className(), ['id' => 'progeria_syndrome_id']);
    }

    /**
     * {@inheritdoc}
     * @return GeneToProgeriaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeneToProgeriaQuery(get_called_class());
    }
}
