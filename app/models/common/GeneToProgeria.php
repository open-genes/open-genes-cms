<?php

namespace cms\models\common;

use Yii;

/**
 * This is the model class for table "gene_to_progeria".
 *
 * @property int $id
 * @property int $gene_id
 * @property int $progeria_syndrome_id
 * @property string $reference
 * @property string $comment_en
 * @property string $comment_ru
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
            [['reference'], 'string', 'max' => 255],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::class, 'targetAttribute' => ['gene_id' => 'id']],
            [['progeria_syndrome_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProgeriaSyndrome::class, 'targetAttribute' => ['progeria_syndrome_id' => 'id']],
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
    public function getProgeriaSyndrome()
    {
        return $this->hasOne(ProgeriaSyndrome::class, ['id' => 'progeria_syndrome_id']);
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
