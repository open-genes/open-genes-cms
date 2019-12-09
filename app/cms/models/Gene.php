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
 * @property int[] $commentCauseIdsArray
 * @property array $functionalClustersArray
 */
class Gene extends \common\models\Gene
{
    protected $functionalClustersIdsArray;
    protected $commentCauseIdsArray;

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
            [['functionalClustersIdsArray', 'commentCauseIdsArray'], 'safe'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'age_id' => 'Происхождение',
            'symbol' => 'HGNC',
            'aliases' => 'Синонимы',
            'name' => 'Название',
            'entrezGene' => 'Entrez Gene',
            'uniprot' => 'Uniprot',
            'why' => 'why',
            'band' => 'Band',
            'locationStart' => 'Location Start',
            'locationEnd' => 'Location End',
            'orientation' => 'Orientation',
            'accPromoter' => 'Acc Promoter',
            'accOrf' => 'Acc Orf',
            'accCds' => 'Acc Cds',
            'references' => 'References',
            'orthologs' => 'Orthologs',
            'commentEvolution' => 'Эволюция',
            'commentFunction' => 'Функции',
            'commentCause' => 'Причины отбора',
            'commentAging' => 'Связь со старением/долголетием',
            'commentEvolutionEN' => 'Эволюция En',
            'commentFunctionEN' => 'Функции En',
            'commentAgingEN' => 'Связь со старением/долголетием En',
            'commentsReferenceLinks' => 'Ссылки на источники',
            'functionalClusters' => 'Функциональные кластеры',
            'functionalClustersIdsArray' => 'Функциональные кластеры',
            'commentCauseIdsArray' => 'Причины отбора',
            'dateAdded' => 'Date Added',
            'userEdited' => 'User Edited',
            'isHidden' => 'Скрыт',
            'expressionChange' => 'Изменение экспр. с возрастом',
            'product_ru' => 'Продукт',
            'product_en' => 'Продукт EN',
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

    public function getCommentCauseIdsArray()
    {
        return CommentCause::find()
            ->select('comment_cause.id')
            ->join('INNER JOIN', 'gene_to_comment_cause', 'gene_to_comment_cause.comment_cause_id = comment_cause.id')
            ->where(['gene_to_comment_cause.gene_id' => $this->id])
            ->asArray()
            ->column();
    }

    public function setFunctionalClustersIdsArray(array $ids)
    {
        $this->functionalClustersIdsArray = $ids;
    }

    public function setCommentCauseIdsArray(array $ids)
    {
        $this->commentCauseIdsArray = $ids;
    }

    public function afterSave($insert, $changedAttributes)
    {
        // todo move to relational active records
        $currentFunctionalClustersIds = $this->getFunctionalClustersIdsArray();
        if($currentFunctionalClustersIds !== $this->functionalClustersIdsArray) {
            if($this->functionalClustersIdsArray) {
                $functionalClustersIdsToDelete = array_diff($currentFunctionalClustersIds, $this->functionalClustersIdsArray);
                $functionalClustersIdsToAdd = array_diff($this->functionalClustersIdsArray, $currentFunctionalClustersIds);
                foreach($functionalClustersIdsToAdd as $functionalClusterIdToAdd) {
                    $geneToFunctionalCluster = new GeneToFunctionalCluster();
                    $geneToFunctionalCluster->gene_id = $this->id;
                    $geneToFunctionalCluster->functional_cluster_id = $functionalClusterIdToAdd;
                    $geneToFunctionalCluster->save();
                }
            } else {
                $functionalClustersIdsToDelete = $currentFunctionalClustersIds;
            }
            GeneToFunctionalCluster::deleteAll(
                ['and', ['gene_id' => $this->id],
                ['in', 'functional_cluster_id', $functionalClustersIdsToDelete]]
            );
        }

        $currentCommentCauseIds = $this->getCommentCauseIdsArray();
        if($currentCommentCauseIds !== $this->commentCauseIdsArray) {
            if($this->commentCauseIdsArray) {
                $commentCausesIdsToDelete = array_diff($currentCommentCauseIds, $this->commentCauseIdsArray);
                $commentCausesIdsToAdd = array_diff($this->commentCauseIdsArray, $currentCommentCauseIds);
                foreach($commentCausesIdsToAdd as $commentCauseIdToAdd) {
                    $geneToCommentCause = new GeneToCommentCause();
                    $geneToCommentCause->gene_id = $this->id;
                    $geneToCommentCause->comment_cause_id = $commentCauseIdToAdd;
                    $geneToCommentCause->save();
                }
            } else {
                $commentCausesIdsToDelete = $currentCommentCauseIds;
            }
            GeneToCommentCause::deleteAll(
                ['and', ['gene_id' => $this->id],
                    ['in', 'comment_cause_id', $commentCausesIdsToDelete]]
            );
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeneToProteinActivities()
    {
        return $this->hasMany(GeneToProteinActivity::className(), ['gene_id' => 'id']);
    }


}