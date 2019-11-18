<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gene_to_function".
 *
 * @property int $id
 * @property int $gene_id
 * @property int $function_id
 * @property int $gene_to_function_relation_type_id
 * @property string $reference
 * @property string $comment
 * @property int $created_at
 * @property int $updated_at
 *
 * @property GeneFunction $geneFunction
 * @property Gene $gene
 * @property GeneToFunctionRelationType $geneToFunctionRelationType
 */
class GeneToFunction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gene_to_function';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gene_id', 'function_id', 'gene_to_function_relation_type_id', 'created_at', 'updated_at'], 'integer'],
            [['reference', 'comment'], 'string', 'max' => 255],
            [['function_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeneFunction::className(), 'targetAttribute' => ['function_id' => 'id']],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::className(), 'targetAttribute' => ['gene_id' => 'id']],
            [['gene_to_function_relation_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeneToFunctionRelationType::className(), 'targetAttribute' => ['gene_to_function_relation_type_id' => 'id']],
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
            'function_id' => 'Function ID',
            'gene_to_function_relation_type_id' => 'Gene To Function Relation Type ID',
            'reference' => 'Reference',
            'comment' => 'Comment',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeneFunction()
    {
        return $this->hasOne(GeneFunction::className(), ['id' => 'function_id']);
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
    public function getGeneToFunctionRelationType()
    {
        return $this->hasOne(GeneToFunctionRelationType::className(), ['id' => 'gene_to_function_relation_type_id']);
    }

    /**
     * {@inheritdoc}
     * @return GeneToFunctionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeneToFunctionQuery(get_called_class());
    }
}
