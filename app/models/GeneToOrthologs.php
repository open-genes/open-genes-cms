<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
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
class GeneToOrthologs extends \app\models\common\GeneToOrthologs
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
                    'id' => 'ID',
                    'gene_id' => 'Gene ID',
                    'ortholog_id' => 'Ortholog ID',
                ];
    }


    /**
    * Gets query for [[Gene]].
    *
    * @return \yii\db\ActiveQuery|\app\models\common\GeneQuery
    */
    public function getGene()
    {
    return $this->hasOne(Gene::class, ['id' => 'gene_id']);
    }

    /**
    * Gets query for [[Ortholog]].
    *
    * @return \yii\db\ActiveQuery|\app\models\common\OrthologsQuery
    */
    public function getOrtholog()
    {
    return $this->hasOne(Orthologs::class, ['id' => 'ortholog_id']);
    }

    public function getLinkedGenesIds()
    {
        return []; // todo implement for column with related genes
    }

}
