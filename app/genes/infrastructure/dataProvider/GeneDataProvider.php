<?php
namespace genes\infrastructure\dataProvider;

use common\models\Gene;
use common\models\GeneQuery;
use yii\web\NotFoundHttpException;

class GeneDataProvider implements GeneDataProviderInterface
{
    /** @var string  */
    private $lang;

    private $fields = [
        'gene.id',
        'gene.symbol',
        'gene.aliases',
        'gene.name',
        'gene.entrezGene',
        'gene.uniprot',
        'gene.why',
        'gene.band',
        'gene.locationStart',
        'gene.locationEnd',
        'gene.orientation',
        'gene.accPromoter',
        'gene.accOrf',
        'gene.accCds',
        'gene.references',
        'gene.orthologs',
        'gene.commentsReferenceLinks',
        'gene.functionalClusters',
        'gene.expressionChange',
    ];

    private $fieldsEn = [
        'gene.commentEvolutionEN comment_evolution',
        'gene.commentFunctionEN comment_function',
        'gene.commentAgingEN comment_aging',
    ];

    private $fieldsRu = [
        'gene.commentEvolution comment_evolution',
        'gene.commentFunction comment_function',
        'gene.commentAging comment_aging',
    ];

    public function __construct($lang = 'en-US')
    {
        $this->lang = $lang;
        $langFields = $lang == 'en-US' ? $this->fieldsEn : $this->fieldsRu;
        $this->fields = array_merge($this->fields, $langFields);
    }

    /** @inheritDoc */
    public function getGene($geneId): array
    {
        $geneArray = Gene::find()
            ->select($this->fields)
            ->withFunctionalClusters($this->lang)
            ->withCommentCause($this->lang)
            ->where(['gene.id' => $geneId])
            ->withAge()
            ->asArray()
            ->groupBy('gene.id')
            ->one();
        if(!$geneArray) {
            throw new NotFoundHttpException("Gene {$geneId} not found");
        }
        return $geneArray;
    }

    /** @inheritDoc */
    public function getLatestGenes(int $count): array
    {
        return Gene::find()
            ->select($this->fields)
            ->where(['in', 'symbol', ['CISD2', 'EMD', 'ADCY5', 'AGTR1']]) // todo хардкод, пока нет реальных изменяемых данных
            ->withAge()
            ->andWhere('isHidden != 1')
            ->orderBy('gene.updated_at desc')
            ->limit($count)
            ->asArray()
            ->all();
    }

    /** @inheritDoc */
    public function getAllGenes(int $count = null): array
    {
        $genesArrayQuery = Gene::find()
            ->select($this->fields)
            ->withAge()
            ->withFunctionalClusters($this->lang)
            ->andWhere('commentEvolution != ""')
            ->andWhere('isHidden != 1')
            ->orderBy('age.order DESC')
            ->limit($count)
            ->groupBy('gene.id')
            ->asArray();
         if($count) {
             $genesArrayQuery->limit($count);
         }
        return $genesArrayQuery->all();
    }

    /** @inheritDoc */
    public function getByFunctionalClustersIds(array $functionalClustersIds): array
    {
        $genesArrayQuery = Gene::find()
            ->select($this->fields)
            ->withAge()
            ->withFunctionalClusters($this->lang)
            ->andWhere('commentEvolution != ""')
            ->andWhere('isHidden != 1')
            ->orderBy('age.order DESC')
            ->groupBy('gene.id')
            ->asArray();
        $joinCounter = 0;
        foreach($functionalClustersIds as $functionalClustersId) {
            $genesArrayQuery->innerJoin(
                "gene_to_functional_cluster filter_cluster_{$joinCounter}",
                ['and', "filter_cluster_{$joinCounter}.gene_id = gene.id", ["filter_cluster_{$joinCounter}.functional_cluster_id" => $functionalClustersId]]);
            $joinCounter++;
        }
        return $genesArrayQuery->all();
    }

    /** @inheritDoc */
    public function getByExpressionChange(string $expressionChange): array
    {
        $genesArrayQuery = Gene::find()
            ->select($this->fields)
            ->withAge()
            ->withFunctionalClusters($this->lang)
            ->andWhere('commentEvolution != ""')
            ->andWhere('isHidden != 1')
            ->andWhere(['gene.expressionChange' => $expressionChange])
            ->orderBy('age.order DESC')
            ->groupBy('gene.id')
            ->asArray();
        return $genesArrayQuery->all();
    }
}