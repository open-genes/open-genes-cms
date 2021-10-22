<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "aging_mechanism_to_gene_ontology".
 *
 * @property int $id
 * @property int|null $gene_ontology_id
 * @property int|null $aging_mechanism_id
 *
 * @property AgingMechanism $agingMechanism
 * @property GeneOntology $geneOntology
 */
class AgingMechanismToGeneOntology extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aging_mechanism_to_gene_ontology';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gene_ontology_id', 'aging_mechanism_id'], 'integer'],
            [['aging_mechanism_id'], 'exist', 'skipOnError' => true, 'targetClass' => AgingMechanism::class, 'targetAttribute' => ['aging_mechanism_id' => 'id']],
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
            'gene_ontology_id' => Yii::t('app', 'Gene Ontology ID'),
            'aging_mechanism_id' => Yii::t('app', 'Aging Mechanism ID'),
        ];
    }

    /**
     * Gets query for [[AgingMechanism]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAgingMechanism()
    {
        return $this->hasOne(AgingMechanism::class, ['id' => 'aging_mechanism_id']);
    }

    /**
     * Gets query for [[GeneOntology]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGeneOntology()
    {
        return $this->hasOne(GeneOntology::class, ['id' => 'gene_ontology_id']);
    }
}
