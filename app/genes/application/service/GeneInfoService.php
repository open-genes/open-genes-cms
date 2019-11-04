<?php
namespace genes\application\service;

use genes\application\dto\GeneViewDto;
use genes\infrastructure\dataProvider\GeneDataProviderInterface;

class GeneInfoService implements GeneInfoServiceInterface
{
    /** @var GeneDataProviderInterface  */
    private $geneRepository;
    
    public function __construct(GeneDataProviderInterface $geneRepository)
    {
        $this->geneRepository = $geneRepository;
    }

    /**
     * @inheritDoc
     */
    public function getGeneViewInfo(int $geneId, string $lang = 'en-US'): GeneViewDto
    {
        $geneArray = $this->geneRepository->getGene($geneId);

        // todo dto mapper
        return $this->mapViewDto($geneArray, $lang);
    }

    /**
     * @inheritDoc
     */
    public function getLatestGenes(int $count, string $lang = 'en-US'): array
    {
        $latestGenesArray = $this->geneRepository->getLatestGenes($count);
        $geneDtos = [];
        foreach ($latestGenesArray as $latestGene) {
            $geneDtos[] = $this->mapViewDto($latestGene, $lang);
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
            $geneDtos[] = $this->mapViewDto($latestGene, $lang);
        }

        return $geneDtos;
    }

    protected function mapViewDto(array $geneArray, string $lang): GeneViewDto
    {
        $geneDto = new GeneViewDto();

        $geneCommentCause =  explode(',', $geneArray['commentCause']);
        foreach ($geneCommentCause as &$commentsCauseItem) {
            $commentsCauseItem = (string) mb_strtolower($commentsCauseItem);
            $commentsCauseItem = preg_replace('/\s+/', '_', $commentsCauseItem);
            $commentsCauseItem = preg_replace('/^_/', '', $commentsCauseItem);
            $commentsCauseItem = preg_replace('/[\/+]/', '_', $commentsCauseItem);
            $commentsCauseItem = \Yii::t('main', $commentsCauseItem); // todo временно. надо перенести переводы в бд, убрать отсюда вызов фреймворка
        }
        $geneFunctionalClusters = $geneArray['functionalClusters'] ? explode(',', $geneArray['functionalClusters']) : [];
        foreach ($geneFunctionalClusters as &$functionalCluster) {
            $functionalCluster = preg_replace('/\s+/', '_', $functionalCluster);
            $functionalCluster = preg_replace('/^_/', '', $functionalCluster);
            $functionalCluster = preg_replace('/[\/]/', '_', $functionalCluster);
            $functionalCluster = \Yii::t('main', $functionalCluster);
        }
        $geneExpression = $lang == 'en-US' ? $geneArray['expressionEN'] : $geneArray['expression'];
        $geneExpression = json_decode($geneExpression, true);
        $geneCommentsReferenceLinks = [];
        $geneCommentsReferenceLinksSource = explode(',', $geneArray['commentsReferenceLinks']);
        foreach ($geneCommentsReferenceLinksSource as $commentsRef) {
            $commentsRefLink = preg_replace('/^(\s?<br>)?\s*\[[0-9\-]*\s*[[0-9\-]*]\s*/', '', $commentsRef);
            $geneCommentsReferenceLinks[$commentsRefLink] = $commentsRef;
        }

        $geneDto->id = (int)$geneArray['id'];
        $geneDto->ageMya = (int)$geneArray['ageMya'];
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
        $geneDto->functionalClusters = $geneFunctionalClusters;
        $geneDto->expression = $geneExpression;
        $geneDto->expressionChange = $geneArray['expressionChange'];

        return $geneDto;
    }
}