<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "gene_ontology_relation".
 *
 * @property int $id
 * @property int|null $gene_ontology_id
 * @property int|null $gene_ontology_parent_id
 */
class GeneOntologyRelation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gene_ontology_relation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gene_ontology_id', 'gene_ontology_parent_id'], 'integer'],
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

    /**
     * {@inheritdoc}
     * @return \app\models\GeneOntologyRelationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\GeneOntologyRelationQuery(get_called_class());
    }
}
