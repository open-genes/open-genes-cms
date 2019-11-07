<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\Query;

/**
 *
 * @property int $id
 * @property string $agePhylo
 * @property int $ageMya
 * @property string $symbol
 * @property string $aliases
 * @property string $name
 * @property int $entrezGene
 * @property string $uniprot
 * @property string $why
 * @property string $band
 * @property int $locationStart
 * @property int $locationEnd
 * @property int $orientation
 * @property string $accPromoter
 * @property string $accOrf
 * @property string $accCds
 * @property string $references
 * @property string $orthologs
 * @property string $commentEvolution
 * @property string $commentFunction
 * @property string $commentCause
 * @property string $commentAging
 * @property string $commentEvolutionEN
 * @property string $commentFunctionEN
 * @property string $commentAgingEN
 * @property string $commentsReferenceLinks
 * @property int $rating
 * @property string $functionalClusters
 * @property int $dateAdded
 * @property string $userEdited
 * @property int $isHidden
 * @property string $expression
 * @property string $expressionEN
 * @property string $expressionChange
 *
 * @property int[] $functionalClustersIdsArray
 * @property array $functionalClustersArray
 */
class Gene extends \yii\db\ActiveRecord
{
    protected $functionalClustersIdsArray;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gene';
    }

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
        return [
            [['ageMya', 'entrezGene', 'locationStart', 'locationEnd', 'orientation', 'rating', 'dateAdded', 'isHidden'], 'integer'],
            [['dateAdded'], 'required'],
            [['expression', 'expressionEN'], 'string'],
            [['agePhylo', 'symbol', 'aliases', 'name', 'uniprot', 'band', 'accPromoter', 'accOrf', 'accCds'], 'string', 'max' => 120],
            [['why', 'references', 'orthologs', 'functionalClusters'], 'string', 'max' => 1000],
            [['commentEvolution', 'commentFunction', 'commentCause', 'commentAging', 'commentEvolutionEN', 'commentFunctionEN', 'commentAgingEN'], 'string', 'max' => 1500],
            [['commentsReferenceLinks'], 'string', 'max' => 2000],
            [['userEdited'], 'string', 'max' => 50],
            [['created_at', 'updated_at'], 'integer'],
            [['functionalClustersIdsArray'], 'safe'],
        ];
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

    /**
     * {@inheritdoc}
     * @return GeneQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeneQuery(get_called_class());
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

    public function getFunctionalClustersArray()
    {
        $result = [];
        $array = FunctionalCluster::find()
            ->select('functional_cluster.id, functional_cluster.name_ru')
            ->join('INNER JOIN', 'gene_to_functional_cluster', 'gene_to_functional_cluster.functional_cluster_id = functional_cluster.id')
            ->where(['gene_to_functional_cluster.gene_id' => $this->id])
            ->asArray()
            ->all();
        foreach ($array as $item) {
            $result[$item['id']] = $item['name_ru'];
        }
        return $result;
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
//            var_dump($currentFunctionalClustersIds, $this->functionalClustersIdsArray, $functionalClustersIdsToAdd, $functionalClustersIdsToDelete); die;
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