<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
use Yii;

/**
 * This is the model class for table "gene_ontology_to_aging_mechanism_visible".
 *
 * @property int $id
 * @property int|null $gene_ontology_id
 * @property int|null $aging_mechanism_id
 */
class GeneOntologyToAgingMechanismVisible extends \app\models\common\GeneOntologyToAgingMechanismVisible
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


    public function getLinkedGenesIds()
    {
        return []; // todo implement for column with related genes
    }

}
