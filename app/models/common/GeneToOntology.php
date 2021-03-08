<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "gene_to_ontology".
 *
 * @property int $id
 * @property int $gene_id
 * @property int $gene_ontology_id
 *
 * @property Gene $gene
 * @property GeneOntology $geneOntology
 */
class GeneToOntology extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gene_to_ontology';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gene_id', 'gene_ontology_id'], 'integer'],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::class, 'targetAttribute' => ['gene_id' => 'id']],
            [['gene_ontology_id'], 'exist', 'skipOnError' => true, 'targetClass' => GeneOntology::class, 'targetAttribute' => ['gene_ontology_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'gene_id' => Yii::t('app', 'Gene ID'),
            'gene_ontology_id' => Yii::t('app', 'Gene Ontology ID'),
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
    public function getGeneOntology()
    {
        return $this->hasOne(GeneOntology::class, ['id' => 'gene_ontology_id']);
    }

    /**
     * {@inheritdoc}
     * @return GeneToOntologyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeneToOntologyQuery(get_called_class());
    }
}
