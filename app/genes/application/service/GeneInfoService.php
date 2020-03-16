<?php
namespace genes\application\service;

use genes\application\dto\FunctionalClusterDto;
use genes\application\dto\GeneFullViewDto;
use genes\application\dto\GeneListViewDto;
use genes\application\dto\LatestGeneViewDto;
use genes\application\dto\PhylumDto;
use genes\infrastructure\dataProvider\GeneDataProviderInterface;
use genes\infrastructure\dataProvider\GeneExpressionDataProviderInterface;
use genes\infrastructure\dataProvider\GeneFunctionsDataProviderInterface;
use yii\base\Exception;

class GeneInfoService implements GeneInfoServiceInterface
{
    /** @var GeneDataProviderInterface  */
    private $geneDataProvider;
    /** @var GeneExpressionDataProviderInterface */
    private $geneExpressionDataProvider;
    /** @var GeneFunctionsDataProviderInterface  */
    private $geneFunctionsDataProvider;

    public function __construct(
        GeneDataProviderInterface $geneRepository,
        GeneExpressionDataProviderInterface $geneExpressionDataProvider,
        GeneFunctionsDataProviderInterface $geneFunctionsDataProvider
    )
    {
        $this->geneDataProvider = $geneRepository;
        $this->geneExpressionDataProvider = $geneExpressionDataProvider;
        $this->geneFunctionsDataProvider = $geneFunctionsDataProvider;
    }

    /**
     * @inheritDoc
     */
    public function getGeneViewInfo(int $geneId, string $lang = 'en-US'): GeneFullViewDto
    {
        $geneArray = $this->geneDataProvider->getGene($geneId);

        $geneDto = $this->mapViewDto($geneArray, $lang);
        $geneDto->expression = $this->geneExpressionDataProvider->getByGeneId($geneId, $lang);
        $geneDto->functions = $this->geneFunctionsDataProvider->getByGeneId($geneId, $lang);

        //todo: создать дата провайдер вместо прямого вызова сервиса. Или лучше вызывать сервис, но внутри него отслоить датапровайдер
        $geneOntologyService = new GeneOntologyService();
        $geneDto->terms = $geneOntologyService->getFunctionsForGene($geneId);

        return $geneDto;
    }

    /**
     * @inheritDoc
     */
    public function getLatestGenes(int $count, string $lang = 'en-US'): array
    {
        $latestGenesArray = $this->geneDataProvider->getLatestGenes($count);
        $geneDtos = [];
        foreach ($latestGenesArray as $latestGene) {
            $geneDtos[] = $this->mapLatestViewDto($latestGene);
        }

        return $geneDtos;
    }
    /**
     * @inheritDoc
     */
    public function getAllGenes(int $count = null, string $lang = 'en-US'): array
    {
        $latestGenesArray = $this->geneDataProvider->getAllGenes($count);
        $geneDtos = [];
        foreach ($latestGenesArray as $latestGene) {
            $geneDtos[] = $this->mapListViewDto($latestGene, $lang);
        }

        return $geneDtos;
    }

    public function getByFunctionalClustersIds(array $functionalClustersIds, string $lang = 'en-US'): array
    {
        $genesArray = $this->geneDataProvider->getByFunctionalClustersIds($functionalClustersIds);
        $geneDtos = [];
        foreach ($genesArray as $gene) {
            $geneDtos[] = $this->mapListViewDto($gene, $lang);
        }

        return $geneDtos;
    }

    public function getByExpressionChange(string $expressionChange, string $lang = 'en-US'): array
    {
        $genesArray = $this->geneDataProvider->getByExpressionChange($this->prepareExpressionChangeForQuery($expressionChange));
        $geneDtos = [];
        foreach ($genesArray as $gene) {
            $geneDtos[] = $this->mapListViewDto($gene, $lang);
        }

        return $geneDtos;
    }

    protected function mapViewDto(array $geneArray, string $lang): GeneFullViewDto
    {
        $geneDto = new GeneFullViewDto();
        $geneCommentsReferenceLinks = [];
        $geneCommentsReferenceLinksSource = explode(',', $geneArray['commentsReferenceLinks']);
        foreach ($geneCommentsReferenceLinksSource as $commentsRef) {
            $commentsRefLink = preg_replace('/^(\s?<br>)?\s*\[[0-9\-]*\s*[[0-9\-]*]\s*/', '', $commentsRef);
            $geneCommentsReferenceLinks[$commentsRefLink] = $commentsRef;
        }
        $geneDto->id = (int)$geneArray['id'];
        $geneDto->origin = $this->prepareOrigin($geneArray);
        $geneDto->symbol = $geneArray['symbol'];
        $geneDto->aliases = explode(' ', $geneArray['aliases']);
        $geneDto->name = $geneArray['name'];
        $geneDto->entrezGene = $geneArray['entrezGene'];
        $geneDto->uniprot = $geneArray['uniprot'];
        $geneDto->commentCause =  explode(',', $geneArray['comment_cause']);
        $geneDto->proteinClasses =  explode('||', $geneArray['protein_class']); // todo одинаковый сепаратор для всех group_concat
        $geneDto->commentEvolution = $geneArray['comment_evolution'];
        $geneDto->commentFunction = $geneArray['comment_function'];
        $geneDto->commentAging = $geneArray['comment_aging'];
        $geneDto->commentsReferenceLinks = $geneCommentsReferenceLinks;
        //todo: PHP Notice","message":"Undefined index: rating
        @$geneDto->rating = $geneArray['rating'];
        $geneDto->functionalClusters = $this->mapFunctionalClusterDtos($geneArray['functional_clusters']);
        $geneDto->expressionChange = $this->prepareExpressionChangeForView($geneArray['expressionChange'], $lang);
        $geneDto->why = explode(',', $geneArray['why']);
        $geneDto->band = $geneArray['band'];
        $geneDto->locationStart = $geneArray['locationStart'];
        $geneDto->locationEnd = $geneArray['locationEnd'];
        $geneDto->orientation = $geneArray['orientation'];
        $geneDto->accPromoter = $geneArray['accPromoter'];
        $geneDto->accOrf = $geneArray['accOrf'];
        $geneDto->accCds = $geneArray['accCds'];
        $geneDto->orthologs = $this->prepareOrthologs($geneArray['orthologs']);

        return $geneDto;
    }

    private function mapLatestViewDto(array $geneArray): LatestGeneViewDto
    {
        $geneDto = new LatestGeneViewDto();
        $geneDto->id = (int)$geneArray['id'];
        $geneDto->origin = $this->prepareOrigin($geneArray);
        $geneDto->symbol = $geneArray['symbol'];
        return $geneDto;
    }

    private function mapListViewDto(array $geneArray, string $lang): GeneListViewDto
    {
        $geneDto = new GeneListViewDto();
        $geneDto->id = (int)$geneArray['id'];
        $geneDto->name = $geneArray['name'];
        $geneDto->origin = $this->prepareOrigin($geneArray);
        $geneDto->symbol = $geneArray['symbol'];
        $geneDto->entrezGene = $geneArray['entrezGene'];
        $geneDto->uniprot = $geneArray['uniprot'];
        $geneDto->expressionChange = $this->prepareExpressionChangeForView($geneArray['expressionChange'], $lang);
        $geneDto->aliases = explode(' ', $geneArray['aliases']);
        $geneDto->functionalClusters = $this->mapFunctionalClusterDtos($geneArray['functional_clusters']);
        return $geneDto;
    }

    /**
     * @param string $geneFunctionalClustersString
     * @return FunctionalClusterDto[]
     */
    private function mapFunctionalClusterDtos($geneFunctionalClustersString): array
    {
        $functionalClusterDtos = [];
        if ($geneFunctionalClustersString) {
            $functionalClustersArray = explode(',', $geneFunctionalClustersString);
            foreach ($functionalClustersArray as $functionalCluster) {
                list($id, $name) = explode('|', $functionalCluster);
                $functionalClusterDto = new FunctionalClusterDto();
                $functionalClusterDto->id = (int)$id;
                $functionalClusterDto->name = $name;
                $functionalClusterDtos[] = $functionalClusterDto;
            }
        }

        return $functionalClusterDtos;
    }

    private function prepareOrigin($geneArray)
    {
        $phylum = new PhylumDto();
        $phylum->id = (int)$geneArray['phylum_id'];
        $phylum->age = $geneArray['phylum_age'];
        $phylum->phylum = $geneArray['phylum_name'];
        $phylum->order = (int)$geneArray['phylum_order'];
        return $phylum;
    }

    private static $expressionChangeEn = [
        'уменьшается' => 'decreased',
        'увеличивается' => 'increased',
        'неоднозначно' => 'mixed',
    ];

    private function prepareExpressionChangeForView($expressionChange, string $lang): ?string // todo изменить в бд хранение изменения экспрессии
    {
        if(!$expressionChange || !isset(self::$expressionChangeEn[$expressionChange])) {
            return null;
        }
        return $lang == 'en-US' ? self::$expressionChangeEn[$expressionChange] : $expressionChange;
    }

    private function prepareExpressionChangeForQuery($expressionChange): ?string // todo изменить в бд хранение изменения экспрессии
    {
        if(!$expressionChange || !in_array($expressionChange, self::$expressionChangeEn)) {
            throw new Exception('invalid $expressionChange value');
        }
        return array_search($expressionChange, self::$expressionChangeEn);
    }

    private function prepareOrthologs($orthologsString): array
    {
        $result = [];
        $orthologs = explode(';', $orthologsString);
        foreach ($orthologs as $orthologString) {
            if(strpos($orthologString, ',')) {
                list($organism, $ortholog) = explode(',', $orthologString);
                $result[$organism] = $ortholog;
            } else {
                $result[$orthologString] = '';
            }
        }
        return $result;
    }
}