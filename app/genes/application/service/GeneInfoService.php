<?php
namespace genes\application\service;

use genes\application\dto\GeneDtoAssemblerInterface;
use genes\application\dto\GeneFullViewDto;
use genes\application\dto\ResearchDtoAssemblerInterface;
use genes\infrastructure\dataProvider\GeneDataProviderInterface;
use genes\infrastructure\dataProvider\GeneExpressionDataProviderInterface;
use genes\infrastructure\dataProvider\GeneFunctionsDataProviderInterface;
use genes\infrastructure\dataProvider\GeneResearchesDataProviderInterface;
use yii\base\Exception;

class GeneInfoService implements GeneInfoServiceInterface
{
    /** @var GeneDataProviderInterface  */
    private $geneDataProvider;

    /** @var GeneExpressionDataProviderInterface */
    private $geneExpressionDataProvider;

    /** @var GeneFunctionsDataProviderInterface  */
    private $geneFunctionsDataProvider;

    /** @var GeneResearchesDataProviderInterface  */
    private $geneResearchesDataProvider;

    /** @var GeneDtoAssemblerInterface */
    private $geneDtoAssembler;

    /** @var ResearchDtoAssemblerInterface */
    private $researchDtoAssembler;

    public function __construct(
        GeneDataProviderInterface $geneRepository,
        GeneExpressionDataProviderInterface $geneExpressionDataProvider,
        GeneFunctionsDataProviderInterface $geneFunctionsDataProvider,
        GeneResearchesDataProviderInterface $geneResearchesDataProvider,
        GeneDtoAssemblerInterface $geneDtoAssembler,
        ResearchDtoAssemblerInterface $researchDtoAssembler
    )
    {
        $this->geneDataProvider = $geneRepository;
        $this->geneExpressionDataProvider = $geneExpressionDataProvider;
        $this->geneFunctionsDataProvider = $geneFunctionsDataProvider;
        $this->geneResearchesDataProvider = $geneResearchesDataProvider;
        $this->geneDtoAssembler = $geneDtoAssembler;
        $this->researchDtoAssembler = $researchDtoAssembler;
    }

    /**
     * @inheritDoc
     */
    public function getGeneViewInfo(int $geneId, string $lang = 'en-US'): GeneFullViewDto
    {
        $geneArray = $this->geneDataProvider->getGene($geneId);

        $geneDto = $this->geneDtoAssembler->mapViewDto($geneArray, $lang);
        $geneDto->expression = $this->geneExpressionDataProvider->getByGeneId($geneId, $lang);
        $geneDto->functions = $this->geneFunctionsDataProvider->getByGeneId($geneId, $lang);
        $geneDto->researches = $this->getGeneResearches($geneId, $lang);
        
        //todo: создать дата провайдер вместо прямого вызова сервиса. Или лучше вызывать сервис, но внутри него отслоить датапровайдер
        $geneOntologyService = new GeneOntologyService();
        $geneDto->terms = $geneOntologyService->getFunctionsForGene($geneDto->entrezGene);

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
            $geneDtos[] = $this->geneDtoAssembler->mapLatestViewDto($latestGene);
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
            $geneDtos[] = $this->geneDtoAssembler->mapListViewDto($latestGene, $lang);
        }

        return $geneDtos;
    }

    public function getByFunctionalClustersIds(array $functionalClustersIds, string $lang = 'en-US'): array
    {
        $genesArray = $this->geneDataProvider->getByFunctionalClustersIds($functionalClustersIds);
        $geneDtos = [];
        foreach ($genesArray as $gene) {
            $geneDtos[] = $this->geneDtoAssembler->mapListViewDto($gene, $lang);
        }

        return $geneDtos;
    }

    public function getByExpressionChange(string $expressionChange, string $lang = 'en-US'): array
    {
        $genesArray = $this->geneDataProvider->getByExpressionChange($this->prepareExpressionChangeForQuery($expressionChange));
        $geneDtos = [];
        foreach ($genesArray as $gene) {
            $geneDtos[] = $this->geneDtoAssembler->mapListViewDto($gene, $lang);
        }

        return $geneDtos;
    }

    private function getGeneResearches($geneId, $lang)
    {
        $lifespanExperiments = $this->geneResearchesDataProvider->getLifespanExperimentsByGeneId($geneId, $lang);
        $geneToProgerias = $this->geneResearchesDataProvider->getGeneToProgeriasByGeneId($geneId, $lang);
        $geneToLongevityEffects = $this->geneResearchesDataProvider->getGeneToLongevityEffectsByGeneId($geneId, $lang);
        $ageRelatedChanges = $this->geneResearchesDataProvider->getAgeRelatedChangesByGeneId($geneId, $lang);
        $interventionResultForVitalProcesses = $this->geneResearchesDataProvider->getGeneInterventionToVitalProcessByGeneId($geneId, $lang);
        $proteinToGenes = $this->geneResearchesDataProvider->getProteinToGenesByGeneId($geneId, $lang);

        return  $this->researchDtoAssembler->mapResearchDto(
            $lifespanExperiments,
            $geneToProgerias,
            $geneToLongevityEffects,
            $ageRelatedChanges,
            $interventionResultForVitalProcesses,
            $proteinToGenes,
            $lang
        );
    }

    private static $expressionChangeEn = [
        'уменьшается' => 'decreased',
        'увеличивается' => 'increased',
        'неоднозначно' => 'mixed',
    ];

    private function prepareExpressionChangeForQuery($expressionChange): ?string // todo изменить в бд хранение изменения экспрессии
    {
        if(!$expressionChange || !in_array($expressionChange, self::$expressionChangeEn)) {
            throw new Exception('invalid $expressionChange value');
        }
        return array_search($expressionChange, self::$expressionChangeEn);
    }

}