<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gene_expression_in_sample".
 *
 * @property int $id
 * @property int $gene_id
 * @property int $sample_id
 * @property int $expression_value
 *
 * @property Gene $gene
 * @property Sample $sample
 */
class GeneExpressionInSample extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gene_expression_in_sample';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gene_id', 'sample_id'], 'integer'],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::className(), 'targetAttribute' => ['gene_id' => 'id']],
            [['sample_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sample::className(), 'targetAttribute' => ['sample_id' => 'id']],
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
            'sample_id' => 'Sample ID',
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
    public function getSample()
    {
        return $this->hasOne(Sample::className(), ['id' => 'sample_id']);
    }

    /**
     * {@inheritdoc}
     * @return GeneExpressionInSampleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeneExpressionInSampleQuery(get_called_class());
    }
}
