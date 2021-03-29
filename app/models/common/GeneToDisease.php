<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "gene_to_disease".
 *
 * @property int $id
 * @property int|null $gene_id
 * @property int|null $disease_id
 * @property string|null $reference
 * @property string|null $comment
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Gene $gene
 * @property Disease $disease
 */
class GeneToDisease extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gene_to_disease';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gene_id', 'disease_id', 'created_at', 'updated_at'], 'integer'],
            [['reference', 'comment'], 'string', 'max' => 255],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::className(), 'targetAttribute' => ['gene_id' => 'id']],
            [['disease_id'], 'exist', 'skipOnError' => true, 'targetClass' => Disease::className(), 'targetAttribute' => ['disease_id' => 'id']],
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
            'disease_id' => 'Disease ID',
            'reference' => 'Reference',
            'comment' => 'Comment',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
     * Gets query for [[Disease]].
     *
     * @return \yii\db\ActiveQuery|DiseaseQuery
     */
    public function getDisease()
    {
        return $this->hasOne(Disease::className(), ['id' => 'disease_id']);
    }

    /**
     * {@inheritdoc}
     * @return GeneToDiseaseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeneToDiseaseQuery(get_called_class());
    }
}
