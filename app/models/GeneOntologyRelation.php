<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
use Yii;

/**
 * This is the model class for table "gene_ontology_relation".
 *
 * @property int $id
 * @property int|null $gene_ontology_id
 * @property int|null $gene_ontology_parent_id
 */
class GeneOntologyRelation extends \app\models\common\GeneOntologyRelation
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
                    'gene_ontology_parent_id' => Yii::t('app', 'Gene Ontology Parent ID'),
                ];
    }


    public function getLinkedGenesIds()
    {
        return []; // todo implement for column with related genes
    }

}
