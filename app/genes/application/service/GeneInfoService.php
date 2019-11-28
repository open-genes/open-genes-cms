<?php
namespace genes\application\service;

use genes\application\dto\FunctionalClusterDto;
use genes\application\dto\GeneFullViewDto;
use genes\application\dto\GeneListViewDto;
use genes\application\dto\LatestGeneViewDto;
use genes\infrastructure\dataProvider\GeneDataProviderInterface;
use genes\infrastructure\dataProvider\GeneExpressionDataProviderInterface;

class GeneInfoService implements GeneInfoServiceInterface
{
    /** @var GeneDataProviderInterface  */
    private $geneRepository;
    /** @var GeneExpressionDataProviderInterface */
    private $geneExpressionDataProvider;

    public function __construct(
        GeneDataProviderInterface $geneRepository,
        GeneExpressionDataProviderInterface $geneExpressionDataProvider)
    {
        $this->geneRepository = $geneRepository;
        $this->geneExpressionDataProvider = $geneExpressionDataProvider;
    }

    /**
     * @inheritDoc
     * @throws \yii\web\NotFoundHttpException
     */
    public function getGeneViewInfo(int $geneId, string $lang = 'en-US'): GeneFullViewDto
    {
        $geneArray = $this->geneRepository->getGene($geneId);

        // todo dto mapper
        $geneDto = $this->mapViewDto($geneArray, $lang);
        $geneDto->expression = $this->geneExpressionDataProvider->getByGeneId($geneId, $lang);
        return $geneDto;
    }

    /**
     * @inheritDoc
     */
    public function getLatestGenes(int $count, string $lang = 'en-US'): array
    {
        $latestGenesArray = $this->geneRepository->getLatestGenes($count);
        $geneDtos = [];
        foreach ($latestGenesArray as $latestGene) {
            $geneDtos[] = $this->mapLatestViewDto($latestGene, $lang);
        }

        return $geneDtos;
    }
    /**
     * @inheritDoc
     */
    public function getAllGenes(int $count = null, string $lang = 'en-US'): array
    {
        $latestGenesArray = $this->geneRepository->getAllGenes($count);
        $geneDtos = [];
        foreach ($latestGenesArray as $latestGene) {
            $geneDtos[] = $this->mapListViewDto($latestGene, $lang);
        }

        return $geneDtos;
    }

    protected function mapViewDto(array $geneArray, string $lang): GeneFullViewDto
    {
        $geneDto = new GeneFullViewDto();

        $geneCommentCause =  explode(',', $geneArray['commentCause']);
        foreach ($geneCommentCause as &$commentsCauseItem) {
            $commentsCauseItem = (string) mb_strtolower($commentsCauseItem);
            $commentsCauseItem = preg_replace('/\s+/', '_', $commentsCauseItem);
            $commentsCauseItem = preg_replace('/^_/', '', $commentsCauseItem);
            $commentsCauseItem = preg_replace('/[\/+]/', '_', $commentsCauseItem);
            $commentsCauseItem = \Yii::t('main', $commentsCauseItem, [], $lang); // todo временно. надо перенести переводы в бд, убрать отсюда вызов фреймворка
        }
        $geneFunctionalClustersString = $lang == 'en-US' ? $geneArray['functional_clusters_en'] : $geneArray['functional_clusters_ru'];
        $geneCommentsReferenceLinks = [];
        $geneCommentsReferenceLinksSource = explode(',', $geneArray['commentsReferenceLinks']);
        foreach ($geneCommentsReferenceLinksSource as $commentsRef) {
            $commentsRefLink = preg_replace('/^(\s?<br>)?\s*\[[0-9\-]*\s*[[0-9\-]*]\s*/', '', $commentsRef);
            $geneCommentsReferenceLinks[$commentsRefLink] = $commentsRef;
        }

        $geneDto->id = (int)$geneArray['id'];
        $geneDto->ageMya = $geneArray['age_mya'];
        $geneDto->agePhylo = $geneArray['age_phylo'];
        $geneDto->symbol = $geneArray['symbol'];
        $geneDto->aliases = explode(' ', $geneArray['aliases']);
        $geneDto->name = $geneArray['name'];
        $geneDto->entrezGene = $geneArray['entrezGene'];
        $geneDto->uniprot = $geneArray['uniprot'];
        $geneDto->commentCause =  $geneCommentCause;
        $geneDto->commentEvolution = $lang == 'en-US' ? $geneArray['commentEvolutionEN'] : $geneArray['commentEvolution'];
        $geneDto->commentFunction = $lang == 'en-US' ? $geneArray['commentFunctionEN'] : $geneArray['commentFunction'];
        $geneDto->commentAging = $lang == 'en-US' ? $geneArray['commentAgingEN'] : $geneArray['commentAging'];
        $geneDto->commentsReferenceLinks = $geneCommentsReferenceLinks;
        $geneDto->rating = $geneArray['rating'];
        $geneDto->functionalClusters = $this->mapFunctionalClusterDtos($geneFunctionalClustersString);
        $geneDto->expressionChange = $geneArray['expressionChange'];

        return $geneDto;
    }

    protected function mapLatestViewDto(array $geneArray, string $lang): LatestGeneViewDto
    {
        $geneDto = new LatestGeneViewDto();
        $geneDto->id = (int)$geneArray['id'];
        $geneDto->ageMya = $geneArray['age_mya'];
        $geneDto->agePhylo = $geneArray['age_phylo'];
        $geneDto->symbol = $geneArray['symbol'];
        return $geneDto;
    }

    protected function mapListViewDto(array $geneArray, string $lang): GeneListViewDto
    {
        $geneFunctionalClustersString = $lang == 'en-US' ? $geneArray['functional_clusters_en'] : $geneArray['functional_clusters_ru'];
        $geneDto = new GeneListViewDto();
        $geneDto->id = (int)$geneArray['id'];
        $geneDto->name = $geneArray['name'];
        $geneDto->ageMya = $geneArray['age_mya'];
        $geneDto->agePhylo = $geneArray['age_phylo'];
        $geneDto->symbol = $geneArray['symbol'];
        $geneDto->entrezGene = $geneArray['entrezGene'];
        $geneDto->uniprot = $geneArray['uniprot'];
        $geneDto->expressionChange = \Yii::t('main', $geneArray['expressionChange'], [], $lang); // todo
        $geneDto->aliases = explode(' ', $geneArray['aliases']);
        $geneDto->functionalClusters = $this->mapFunctionalClusterDtos($geneFunctionalClustersString);
        return $geneDto;
    }

    /**
     * @param string $geneFunctionalClustersString
     * @return FunctionalClusterDto[]
     */
    private function mapFunctionalClusterDtos(string $geneFunctionalClustersString): array
    {
        $functionalClusterDtos = [];
        $functionalClustersArray = explode(',', $geneFunctionalClustersString);
        foreach ($functionalClustersArray as $functionalCluster) {
            list($id, $name) = explode('|', $functionalCluster);
            $functionalClusterDto = new FunctionalClusterDto();
            $functionalClusterDto->id = $id;
            $functionalClusterDto->name = $name;
            $functionalClusterDtos[] = $functionalClusterDto;
        }
        return $functionalClusterDtos;
    }
}