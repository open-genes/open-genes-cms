<?php
namespace genes\application\service;

use genes\application\dto\GeneViewDto;
use genes\infrastructure\repository\GeneRepositoryInterface;

class GeneInfoService implements GeneInfoServiceInterface
{
    /** @var GeneRepositoryInterface  */
    private $geneRepository;
    
    public function __construct(GeneRepositoryInterface $geneRepository)
    {
        $this->geneRepository = $geneRepository;
    }

    /**
     * @inheritDoc
     */
    public function getGeneViewInfo(int $geneId): GeneViewDto
    {
        $geneArray = $this->geneRepository->getGene($geneId);

        // todo dto mapper
        return $this->mapDto($geneArray);
    }

    /**
     * @inheritDoc
     */
    public function getLatestGenes(int $count): array
    {
        $latestGenesArray = $this->geneRepository->getLatestGenes($count);
        $geneDtos = [];
        foreach ($latestGenesArray as $latestGene) {
            $geneDtos[] = $this->mapDto($latestGene);
        }

        return $geneDtos;
    }

    protected function mapDto(array $geneArray): GeneViewDto
    {
        $geneDto = new GeneViewDto();

        $geneCommentCause =  explode(',', $geneArray['commentCause']);
        foreach ($geneCommentCause as &$commentsCauseItem) {
            $commentsCauseItem = (string) mb_strtolower($commentsCauseItem);
            $commentsCauseItem = preg_replace('/\s+/', '_', $commentsCauseItem);
            $commentsCauseItem = preg_replace('/^_/', '', $commentsCauseItem);
            $commentsCauseItem = preg_replace('/[\/+]/', '_', $commentsCauseItem);
        }
        $geneFunctionalClusters = explode(',', $geneArray['functionalClusters']);
        foreach ($geneFunctionalClusters as &$functionalCluster) {
            $functionalCluster = preg_replace('/\s+/', '_', $functionalCluster);
            $functionalCluster = preg_replace('/^_/', '', $functionalCluster);
            $functionalCluster = preg_replace('/[\/]/', '_', $functionalCluster);
        }
        $geneExpression = \Yii::$app->language == 'en-US' ? $geneArray['expressionEN'] : $geneArray['expression'];
        $geneExpression = json_decode($geneExpression, true);
        $geneCommentsReferenceLinks = [];
        $geneCommentsReferenceLinksSource = explode(',', $geneArray['commentsReferenceLinks']);
        foreach ($geneCommentsReferenceLinksSource as $commentsRef) {
            $commentsRefLink = preg_replace('/^(\s?<br>)?\s*\[[0-9\-]*\s*[[0-9\-]*]\s*/', '', $commentsRef);
            $geneCommentsReferenceLinks[$commentsRefLink] = $commentsRef;
        }

        $geneDto->id = (int)$geneArray['ID'];
        $geneDto->ageMya = (int)$geneArray['ageMya'];
        $geneDto->symbol = $geneArray['symbol'];
        $geneDto->aliases = explode(',', $geneArray['aliases']);
        $geneDto->name = $geneArray['name'];
        $geneDto->entrezGene = $geneArray['entrezGene'];
        $geneDto->uniprot = $geneArray['uniprot'];
        $geneDto->commentCause =  $geneCommentCause;
        $geneDto->commentEvolution = \Yii::$app->language == 'en-US' ? $geneArray['commentEvolutionEN'] : $geneArray['commentEvolution'];
        $geneDto->commentFunction = \Yii::$app->language == 'en-US' ? $geneArray['commentFunctionEN'] : $geneArray['commentFunction'];
        $geneDto->commentAging = \Yii::$app->language == 'en-US' ? $geneArray['commentAgingEN'] : $geneArray['commentAging'];
        $geneDto->commentsReferenceLinks = $geneCommentsReferenceLinks;
        $geneDto->rating = $geneArray['rating'];
        $geneDto->functionalClusters = $geneFunctionalClusters;
        $geneDto->expression = $geneExpression;

        return $geneDto;
    }
}