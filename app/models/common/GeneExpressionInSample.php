<?php

namespace cms\models\common;

use Yii;

/**
 * This is the model class for table "gene_expression_in_sample".
 *
 * @property double $expression_value
 * @property int $id
 * @property int $gene_id
 * @property int $sample_id
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
            [['expression_value'], 'required'],
            [['expression_value'], 'number'],
            [['gene_id', 'sample_id'], 'integer'],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::class, 'targetAttribute' => ['gene_id' => 'id']],
            [['sample_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sample::class, 'targetAttribute' => ['sample_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'expression_value' => 'Expression Value',
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
        return $this->hasOne(Gene::class, ['id' => 'gene_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSample()
    {
        return $this->hasOne(Sample::class, ['id' => 'sample_id']);
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
