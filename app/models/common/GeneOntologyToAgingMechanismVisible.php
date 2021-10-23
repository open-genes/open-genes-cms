<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "gene_ontology_to_aging_mechanism_visible".
 *
 * @property int $id
 * @property int|null $gene_ontology_id
 * @property int|null $aging_mechanism_id
 */
class GeneOntologyToAgingMechanismVisible extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gene_ontology_to_aging_mechanism_visible';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gene_ontology_id', 'aging_mechanism_id'], 'integer'],
            [['gene_ontology_id', 'aging_mechanism_id'], 'unique', 'targetAttribute' => ['gene_ontology_id', 'aging_mechanism_id']],
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
     * {@inheritdoc}
     * @return \app\models\GeneOntologyToAgingMechanismVisibleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\GeneOntologyToAgingMechanismVisibleQuery(get_called_class());
    }
}
