<?php
namespace genes\application\service;

use genes\application\dto\GenViewDto;
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
     * @param int $geneId
     * @return GenViewDto
     * @throws \yii\web\NotFoundHttpException
     */
    public function getGeneViewInfo(int $geneId): GenViewDto
    {
        $geneArray = $this->geneRepository->getGene($geneId);
        $geneDto = new GenViewDto();
        
        // todo dto mapper
        $geneDto->hylo = $geneArray['hylo'];
        $geneDto->ageMya = $geneArray['ageMya'];
        $geneDto->symbol = $geneArray['symbol'];
        $geneDto->aliases = $geneArray['aliases'];
        $geneDto->name = $geneArray['name'];
        $geneDto->entrezGene = $geneArray['entrezGene'];
        $geneDto->uniprot = $geneArray['uniprot'];
        $geneDto->why = $geneArray['why'];
        $geneDto->band = $geneArray['band'];
        $geneDto->locationStart = $geneArray['locationStart'];
        $geneDto->locationEnd = $geneArray['locationEnd'];
        $geneDto->orientation = $geneArray['orientation'];
        $geneDto->accPromoter = $geneArray['accPromoter'];
        $geneDto->accOrf = $geneArray['accOrf'];
        $geneDto->accCds = $geneArray['accCds'];
        $geneDto->references = $geneArray['references'];
        $geneDto->orthologs = $geneArray['orthologs'];
        $geneDto->commentEvolution = $geneArray['commentEvolution'];
        $geneDto->commentFunction = $geneArray['commentFunction'];
        $geneDto->commentCause = $geneArray['commentCause'];
        $geneDto->commentAging = $geneArray['commentAging'];
        $geneDto->commentEvolutionEN = $geneArray['commentEvolutionEN'];
        $geneDto->commentFunctionEN = $geneArray['commentFunctionEN'];
        $geneDto->commentAgingEN = $geneArray['commentAgingEN'];
        $geneDto->commentsReferenceLinks = $geneArray['commentsReferenceLinks'];
        $geneDto->rating = $geneArray['rating'];
        $geneDto->functionalClusters = $geneArray['functionalClusters'];
        $geneDto->dateAdded = $geneArray['dateAdded'];
        $geneDto->userEdited = $geneArray['userEdited'];
        $geneDto->isHidden = $geneArray['isHidden'];
        $geneDto->expression = $geneArray['expression'];
        $geneDto->expressionEN = $geneArray['expressionEN'];

        return $geneDto;
    }
}