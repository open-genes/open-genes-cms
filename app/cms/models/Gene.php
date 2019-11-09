<?php

namespace cms\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * @property int[] $functionalClustersIdsArray
 * @property array $functionalClustersArray
 */
class Gene extends \common\models\Gene
{
    protected $functionalClustersIdsArray;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(), [
            [['functionalClustersIdsArray'], 'safe'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'agePhylo' => 'Age Phylo',
            'ageMya' => 'Age Mya',
            'symbol' => 'Symbol',
            'aliases' => 'Aliases',
            'name' => 'Name',
            'entrezGene' => 'Entrez Gene',
            'uniprot' => 'Uniprot',
            'why' => 'Why',
            'band' => 'Band',
            'locationStart' => 'Location Start',
            'locationEnd' => 'Location End',
            'orientation' => 'Orientation',
            'accPromoter' => 'Acc Promoter',
            'accOrf' => 'Acc Orf',
            'accCds' => 'Acc Cds',
            'references' => 'References',
            'orthologs' => 'Orthologs',
            'commentEvolution' => 'Comment Evolution',
            'commentFunction' => 'Comment Function',
            'commentCause' => 'Comment Cause',
            'commentAging' => 'Comment Aging',
            'commentEvolutionEN' => 'Comment Evolution En',
            'commentFunctionEN' => 'Comment Function En',
            'commentAgingEN' => 'Comment Aging En',
            'commentsReferenceLinks' => 'Comments Reference Links',
            'rating' => 'Rating',
            'functionalClusters' => 'Functional Clusters',
            'functionalClustersIdsArray' => 'Functional Clusters',
            'dateAdded' => 'Date Added',
            'userEdited' => 'User Edited',
            'isHidden' => 'Is Hidden',
            'expression' => 'Expression',
            'expressionEN' => 'Expression En',
        ];
    }

    public function search($params = [])
    {
        $query = self::find();

        if($params) {
            $this->load($params);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->addCondition($query, 'symbol', true);
        $this->addCondition($query, 'aliases', true);
        $this->addCondition($query, 'name', true);
        $this->addCondition($query, 'ageMya');

        return $dataProvider;
    }

    /**
     * @param $query ActiveQuery
     * @param $attribute
     * @param bool $partialMatch
     */
    protected function addCondition(&$query, $attribute, $partialMatch = false)
    {
        $value = $this->$attribute;
        if (trim($value) === '') {
            return;
        }
        if ($partialMatch) {
            $query->andWhere(['like', $attribute, $value]);
        } else {
            $query->andWhere([$attribute => $value]);
        }
    }

    public function getFunctionalClustersIdsArray()
    {
        return FunctionalCluster::find()
            ->select('functional_cluster.id')
            ->join('INNER JOIN', 'gene_to_functional_cluster', 'gene_to_functional_cluster.functional_cluster_id = functional_cluster.id')
            ->where(['gene_to_functional_cluster.gene_id' => $this->id])
            ->asArray()
            ->column();
    }

    public function setFunctionalClustersIdsArray(array $ids)
    {
        $this->functionalClustersIdsArray = $ids;
    }

    public function afterSave($insert, $changedAttributes)
    {
        $currentFunctionalClustersIds = $this->getFunctionalClustersIdsArray();
        if($currentFunctionalClustersIds !== $this->functionalClustersIdsArray) {
            $functionalClustersIdsToAdd = array_diff($this->functionalClustersIdsArray, $currentFunctionalClustersIds);
            $functionalClustersIdsToDelete = array_diff($currentFunctionalClustersIds, $this->functionalClustersIdsArray);
            foreach($functionalClustersIdsToAdd as $functionalClusterIdToAdd) {
                $geneToFunctionalCluster = new GeneToFunctionalCluster();
                $geneToFunctionalCluster->gene_id = $this->id;
                $geneToFunctionalCluster->functional_cluster_id = $functionalClusterIdToAdd;
                $geneToFunctionalCluster->save();
            }
            GeneToFunctionalCluster::deleteAll(
                ['and', ['gene_id' => $this->id],
                ['in', 'functional_cluster_id', $functionalClustersIdsToDelete]]
            );
        }
        parent::afterSave($insert, $changedAttributes);
    }

}