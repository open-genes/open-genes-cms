<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use app\models\common\GeneToDisease;
use app\models\common\GeneToSource;
use app\models\traits\ConditionActiveRecordTrait;
use app\models\common\GeneToProteinClass;
use Ramsey\Uuid\Uuid;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * @property int[] $functionalClustersIdsArray
 * @property int[] $diseasesIdsArray
 * @property int[] $commentCauseIdsArray
 * @property int[] $agingMechanismIdsArray
 * @property int[] $proteinClassesIdsArray
 * @property array $functionalClustersArray
 */
class Gene extends common\Gene
{
    use ConditionActiveRecordTrait;

    public $newGenesNcbiIds;
    public $filledExperiments;

    protected $functionalClustersIdsArray;
    protected $agingMechanismIdsArray;
    protected $diseasesIdsArray;
    protected $commentCauseIdsArray;
    protected $proteinClassesIdsArray;
    protected $sourcesIdsArray;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            ChangelogBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(), [
            [['functionalClustersIdsArray', 'diseasesIdsArray', 'commentCauseIdsArray', 'agingMechanismIdsArray',
                'proteinClassesIdsArray', 'newGenesNcbiIds', 'filledExperiments', 'sourcesIdsArray'], 'safe'],
            ['ncbi_id', 'unique'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'family_phylum_id' => 'Происхождение семейства гена',
            'phylum_id' => 'Происхождение гена',
            'symbol' => 'HGNC',
            'aliases' => 'Синонимы',
            'name' => 'Название',
            'ncbi_id' => 'NCBI id',
            'uniprot' => 'Uniprot',
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
            'uniprot_summary_ru' => 'Описание белка UniProt (Ru)',
            'uniprot_summary_en' => 'Описание белка UniProt (En)',
            'commentAging' => 'Связь со старением/долголетием',
            'commentEvolutionEN' => 'Эволюция En',
            'commentAgingEN' => 'Связь со старением/долголетием En',
            'functionalClusters' => 'Возрастозависимые процессы',
            'functionalClustersIdsArray' => 'Возрастозависимые процессы',
            'agingMechanismIdsArray' => 'Механизмы',
            'diseasesIdsArray' => 'Заболевания',
            'commentCauseIdsArray' => 'Причины отбора',
            'userEdited' => 'User Edited',
            'isHidden' => 'Скрыт',
            'proteinClassesIdsArray' => 'Классы белков',
            'sourcesIdsArray' => 'Источники',
            'expressionChange' => 'Изменение экспрессии',
            'protein_complex_ru' => 'Белковый комплекс Ru',
            'protein_complex_en' => 'Белковый комплекс En',
            'ncbi_summary_ru' => 'Описание гена (NCBI) Ru',
            'ncbi_summary_en' => 'Описание гена (NCBI) En',
            'og_summary_en' => 'Описание белка Open Genes (En)',
            'og_summary_ru' => 'Описание белка Open Genes (Ru)',
        ];
    }

    public const EXPERIMENTS = [
        'lifespan_experiment' => 'LifespanExperiment',
        'age_related_change' => 'AgeRelatedChange',
        'gene_intervention_to_vital_process' => 'GeneInterventionToVitalProcess',
        'protein_to_gene' => 'ProteinToGene',
        'gene_to_progeria' => 'GeneToProgeria',
        'gene_to_longevity_effect' => 'GeneToLongevityEffect',
        'gene_to_additional_evidence' => 'GeneToAdditionalEvidence',
    ];

    public function search($params = [])
    {
        $query = self::find();

        if ($params) {
            $this->load($params);
        }
        $this->addCondition($query, 'id');
        $this->addCondition($query, 'symbol', true);
        $this->addCondition($query, 'aliases', true);
        $this->addCondition($query, 'name', true);
        $this->addCondition($query, 'ncbi_id');
        $this->addExperimentsCondition($query);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->prepare();
        return $dataProvider;
    }

    private function addExperimentsCondition(ActiveQuery &$query) // todo make by query builder
    {
        if ($this->filledExperiments) {
            $conditionType = '';
            $conditionString = '';
            foreach (self::EXPERIMENTS as $table => $experiment) {
                $query->leftJoin($table, $table . '.gene_id = gene.id');
                if ($this->filledExperiments === '+') {
                    $conditionString .= " {$conditionType} {$table}.gene_id is not null";
                    $conditionType = 'or';
                } else {
                    $conditionString .= " {$conditionType} {$table}.gene_id is null";
                    $conditionType = 'and';
                }
            }
            $query->groupBy('gene.id');
            $query->andWhere($conditionString);
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

    public function getDiseasesIdsArray()
    {
        return Disease::find()
            ->select('disease.id')
            ->join('INNER JOIN', 'gene_to_disease', 'gene_to_disease.disease_id = disease.id')
            ->where(['gene_to_disease.gene_id' => $this->id])
            ->asArray()
            ->column();
    }

    public function getAgingMechanismIdsArray()
    {
        return AgingMechanism::find()
            ->select('aging_mechanism.uuid')
            ->join('INNER JOIN', 'aging_mechanism_to_gene', 'aging_mechanism_to_gene.aging_mechanism_id = aging_mechanism.id')
            ->where(['aging_mechanism_to_gene.gene_id' => $this->id])
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

    public function getProteinClassesIdsArray()
    {
        return ProteinClass::find()
            ->select('protein_class.id')
            ->join('INNER JOIN', 'gene_to_protein_class', 'gene_to_protein_class.protein_class_id = protein_class.id')
            ->where(['gene_to_protein_class.gene_id' => $this->id])
            ->asArray()
            ->column();
    }

    public function getSourcesIdsArray()
    {
        return GeneToSource::find()
            ->select('source_id')
            ->where(['gene_id' => $this->id])
            ->asArray()
            ->column();
    }

    public function setFunctionalClustersIdsArray(array $ids)
    {
        $this->functionalClustersIdsArray = $ids;
    }

    public function setAgingMechanismIdsArray(array $uuids)
    {
        $this->agingMechanismIdsArray = $uuids;
    }

    public function setDiseasesIdsArray(array $ids)
    {
        $this->diseasesIdsArray = $ids;
    }

    public function setCommentCauseIdsArray(array $ids)
    {
        $this->commentCauseIdsArray = $ids;
    }

    public function setProteinClassesIdsArray(array $ids)
    {
        $this->proteinClassesIdsArray = $ids;
    }

    public function setSourcesIdsArray(array $ids)
    {
        $this->sourcesIdsArray = $ids;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (Yii::$app instanceof \yii\console\Application) { // todo продумать нормальный фикс
            return parent::afterSave($insert, $changedAttributes);
        }
        $this->updateRelations($this->getFunctionalClustersIdsArray(),'functionalClustersIdsArray', GeneToFunctionalCluster::class, 'functional_cluster_id');
        $this->updateRelations($this->getAgingMechanismIdsArray(),'agingMechanismIdsArray', AgingMechanismToGene::class, 'aging_mechanism_id');
        $this->updateRelations($this->getCommentCauseIdsArray(),'commentCauseIdsArray', GeneToCommentCause::class, 'comment_cause_id');
        $this->updateRelations($this->getProteinClassesIdsArray(),'proteinClassesIdsArray', GeneToProteinClass::class, 'protein_class_id');
        $this->updateRelations($this->getDiseasesIdsArray(),'diseasesIdsArray', GeneToDisease::class, 'disease_id');
        $this->updateRelations($this->getSourcesIdsArray(),'sourcesIdsArray', GeneToSource::class, 'source_id');

        parent::afterSave($insert, $changedAttributes);
    }

    public function createByNCBIIds()
    {
        $genesNCBIIdsArray = explode(PHP_EOL, $this->newGenesNcbiIds);
        if (is_array($genesNCBIIdsArray)) {
            foreach ($genesNCBIIdsArray as $geneNCBIId) {
                $geneNCBIId = (int)trim($geneNCBIId, PHP_EOL . ' \t\n\r,;');
                $arGene = self::find()->where(['ncbi_id' => $geneNCBIId])->one();
                if (!$arGene) {
                    $arGene = new self();
                    $arGene->ncbi_id = $geneNCBIId;
                    $arGene->isHidden = 1;
                    if (!$arGene->save()) {
                        $this->addError('newGenesNcbiIds', current($arGene->getFirstErrors()));
                    }
                }
            }
        }
        return empty($this->errors);
    }

    public static function getAllNamesAsArray()
    {
        $genes = self::find()
            ->select(['id', 'symbol', 'name'])
            ->asArray()
            ->all();
        $result = [];
        foreach ($genes as $gene) {
            $result[$gene['id']] = "{$gene['symbol']} ({$gene['name']})";
        }
        return $result;
    }

    public function getAllExperimentsCounts()
    {
        $counts = [];
        foreach (self::EXPERIMENTS as $table => $experiment) {
            $count = $this->hasMany('app\models\\' . $experiment, ['gene_id' => 'id'])->count();
            if ($count) {
                $counts[$table] = $count;
            }
        }
        return $counts;
    }
    
    /**
     * @return LifespanExperiment[]
     */
    public function getLifespanExperimentsList()
    {
        return LifespanExperiment::find()
            ->where(['gene_id' => $this->id])
            ->andWhere(['type' => 'experiment'])
        ->all();
    }

    public function beforeSave($insert): bool
    {
        $this->aliases = str_replace(',', '', $this->aliases);
        return parent::beforeSave($insert);
    }

    private function updateRelations($currentIdsArray, $geneProp, $relationClassName, $relationProp) {
        if ($currentIdsArray !== $this->$geneProp) {
            if ($this->$geneProp) {
                $relationIdsArrayToDelete = array_diff($currentIdsArray, $this->$geneProp);
                $relationIdsArrayToAdd = array_diff($this->$geneProp, $currentIdsArray);
                foreach ($relationIdsArrayToAdd as $relationIdArrayToAdd) {
                    $geneToRelation = new $relationClassName;
                    if ($geneProp === 'agingMechanismIdsArray') {
                        $geneToRelation->uuid = Uuid::uuid4()->toString();
                    }
                    $geneToRelation->gene_id = $this->id;
                    $geneToRelation->$relationProp = $relationIdArrayToAdd;
                    $geneToRelation->save();
                }
            } else {
                $relationIdsArrayToDelete = $currentIdsArray;
            }
            $arsToDelete = $relationClassName::find()->where(
                ['and', ['gene_id' => $this->id],
                    ['in', $relationProp, $relationIdsArrayToDelete]]
            )->all();
            foreach ($arsToDelete as $arToDelete) { // one by one for properly triggering "afterDelete" event
                $arToDelete->delete();
            }
        }
    }
}