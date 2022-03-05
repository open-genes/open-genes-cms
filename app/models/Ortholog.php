<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\traits\RuEnActiveRecordTrait;
use Yii;

/**
 * This is the model class for table "ortholog".
 *
 * @property int $id
 * @property string|null $symbol
 * @property int|null $model_organism_id
 * @property string|null $external_base_name
 * @property string|null $external_base_id
 *
 * @property GeneToOrtholog[] $geneToOrtholog
 * @property ModelOrganism $organism
 */
class Ortholog extends common\Ortholog
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
                    'symbol' => 'Symbol',
                    'model_organism_id' => 'Organism ID',
                    'external_base_name' => 'External base name',
                    'external_base_id' => 'External base id',
                ];
    }


    /**
    * Gets query for [[GeneToOrtholog]].
    *
    * @return \yii\db\ActiveQuery|\app\models\common\GeneToOrthologQuery
    */
    public function getGeneToOrtholog()
    {
    return $this->hasMany(GeneToOrtholog::class, ['ortholog_id' => 'id']);
    }

    /**
    * Gets query for [[Organism]].
    *
    * @return \yii\db\ActiveQuery|\app\models\common\ModelOrganismQuery
    */
    public function getOrganism()
    {
    return $this->hasOne(ModelOrganism::class, ['id' => 'model_organism_id']);
    }

    public function getLinkedGenesIds()
    {
        return []; // todo implement for column with related genes
    }

    public static function createNewByIds($ids, $generalLifespanId, $geneId)
    {
        $modelOrganismId = self::getCurrentModelOrganismId($generalLifespanId);
        if (!empty($ids) && is_array($ids)) {
            foreach ($ids as $id) {
                if (is_numeric($id)) {
                    continue;
                }
                $newOrtholog = self::createFromNameString($id, $modelOrganismId);
                self::createRelationToGene($geneId, $newOrtholog->id);
            }
        }
    }

    public static function getIdByName($name) {
        return self::find()->select('id')->where(
                ['symbol' => $name]
        )->one();
    }

    public static function getByOrganismAndGene($modelOrganismId, $geneId){
        $orthologs = self::find()
            ->select(['ortholog.id', 'ortholog.symbol'])
            ->innerJoin('gene_to_ortholog', 'ortholog.id=gene_to_ortholog.ortholog_id')
            ->where(['ortholog.model_organism_id' => $modelOrganismId])
            ->andWhere(['gene_to_ortholog.gene_id' => $geneId])
            ->asArray()
            ->all();
        $result = [];
        foreach ($orthologs as $ortholog) {
            $result[$ortholog['id']] = "{$ortholog['symbol']}";
        }
        return $result;

    }

    public static function getByGeneralLe($generalId, $geneId)
    {
        $modelOrganismId = self::getCurrentModelOrganismId($generalId);
        return self::getByOrganismAndGene($modelOrganismId, $geneId);

    }

    private static function createRelationToGene($geneId, $orthologId) {
        $geneToRelation = new GeneToOrtholog();
        $geneToRelation->gene_id = $geneId;
        $geneToRelation->ortholog_id = $orthologId;
        $geneToRelation->save();
    }


    private static function createFromNameString(string $symbol, int $modelOrganismId) {
        $model = parent::find()
            ->where(['symbol' => $symbol])
            ->andWhere(['model_organism_id' => $modelOrganismId])
            ->one();
        if(!$model) {
            $model = new self();
            $model->symbol = $symbol;
            $model->model_organism_id = $modelOrganismId;
            $model->save();
        }
        return $model;
    }

    private static function getCurrentModelOrganismId($generalLifespanId)
    {
        return GeneralLifespanExperiment::find()
            ->select(['model_organism_id'])
            ->where(['id' => $generalLifespanId])
            ->one()
            ->model_organism_id;
    }
}
