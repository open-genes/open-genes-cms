<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
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
class AgingMechanismToGeneOntology extends \app\models\common\AgingMechanismToGeneOntology
{
    use RuEnActiveRecordTrait;

    public $name;

    /**
    * {@inheritdoc}
    */
    public function behaviors()
    {
        return [
            ChangelogBehavior::class
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

    public function getLinkedGenesIds()
    {
        return []; // todo implement for column with related genes
    }

}
