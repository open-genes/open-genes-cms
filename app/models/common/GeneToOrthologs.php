<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "gene_to_orthologs".
 *
 * @property int $id
 * @property int|null $gene_id
 * @property int|null $ortholog_id
 *
 * @property Gene $gene
 * @property Orthologs $ortholog
 */
class GeneToOrthologs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gene_to_orthologs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gene_id', 'ortholog_id'], 'integer'],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::class, 'targetAttribute' => ['gene_id' => 'id']],
            [['ortholog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orthologs::class, 'targetAttribute' => ['ortholog_id' => 'id']],
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
            'ortholog_id' => 'Ortholog ID',
        ];
    }

    /**
     * Gets query for [[Gene]].
     *
     * @return \yii\db\ActiveQuery|GeneQuery
     */
    public function getGene()
    {
        return $this->hasOne(Gene::class, ['id' => 'gene_id']);
    }

    /**
     * Gets query for [[Ortholog]].
     *
     * @return \yii\db\ActiveQuery|OrthologsQuery
     */
    public function getOrtholog()
    {
        return $this->hasOne(Orthologs::class, ['id' => 'ortholog_id']);
    }

    /**
     * {@inheritdoc}
     * @return GeneToOrthologsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeneToOrthologsQuery(get_called_class());
    }
}
