<?php


namespace app\console\controllers;


use app\console\service\ParseDiseasesServiceInterface;
use app\console\service\ParseMyGeneServiceInterface;
use app\console\service\ParseNCBIServiceInterface;
use app\console\service\ParseProteinAtlasServiceInterface;
use app\service\GeneOntologyServiceInterface;
use yii\console\Controller;

class GetDataController extends Controller
{
    /**
     * params: $onlyNew = 'true' $geneNcbiIds = 1,2,3 $geneSearchName = ''
     * @param string $onlyNew
     * @param string|null $geneNcbiIds
     * @param string|null $geneSearchName
     */
    public function actionGetProteinClasses(string $onlyNew = 'true', string $geneNcbiIds = null, string $geneSearchName = '')
    {
        $onlyNew = filter_var($onlyNew, FILTER_VALIDATE_BOOLEAN);
        $geneNcbiIdsArray = $geneNcbiIds ? explode(',', $geneNcbiIds) : [];

        /** @var ParseProteinAtlasServiceInterface $proteinAtlasService */
        $proteinAtlasService = \Yii::$container->get(ParseProteinAtlasServiceInterface::class);
        $proteinAtlasService->parseClasses($onlyNew, $geneNcbiIdsArray, $geneSearchName);

    }

    /**
     * params: $onlyNew = 'true' $geneNcbiIds = 1,2,3 $geneSearchName = ''
     * @param string $onlyNew
     * @param string|null $geneNcbiIds
     * @param string $geneSearchName
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function actionGetProteinAtlas(string $onlyNew = 'true', string $geneNcbiIds = null, string $geneSearchName = '')
    {
        $onlyNew = filter_var($onlyNew, FILTER_VALIDATE_BOOLEAN);
        $geneNcbiIdsArray = $geneNcbiIds ? explode(',', $geneNcbiIds) : [];

        /** @var ParseProteinAtlasServiceInterface $proteinAtlasService */
        $proteinAtlasService = \Yii::$container->get(ParseProteinAtlasServiceInterface::class);
        $proteinAtlasService->parseFullAtlas($onlyNew, $geneNcbiIdsArray, $geneSearchName);

    }

    /**
     * params: $onlyNew = 'true' $geneNcbiIds = 1,2,3
     * @param string $onlyNew
     * @param string|null $geneNcbiIds
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function actionGetDiseasesFromBiocomp(string $onlyNew = 'true', string $geneNcbiIds = null)
    {
        $onlyNew = filter_var($onlyNew, FILTER_VALIDATE_BOOLEAN);
        $geneNcbiIdsArray = $geneNcbiIds ? explode(',', $geneNcbiIds) : [];

        /** @var ParseDiseasesServiceInterface $diseasesService */
        $diseasesService = \Yii::$container->get(ParseDiseasesServiceInterface::class);
        $diseasesService->parseBiocomp($onlyNew, $geneNcbiIdsArray);

    }

    /**
     * params: $onlyNew = 'true' $geneNcbiIds = 1,2,3
     * @param string $onlyNew
     * @param null|string $geneNcbiIds
     */
    public function actionGetGeneExpression(string $onlyNew = 'true', string $geneNcbiIds = null)
    {
        $onlyNew = filter_var($onlyNew, FILTER_VALIDATE_BOOLEAN);
        $geneNcbiIdsArray = $geneNcbiIds ? explode(',', $geneNcbiIds) : [];

        /** @var  ParseNCBIServiceInterface $ncbiService */
        $ncbiService = \Yii::$container->get(ParseNCBIServiceInterface::class);
        $ncbiService->parseExpression($onlyNew, $geneNcbiIdsArray);
    }

    /**
     * params: $onlyNew = 'true' $geneNcbiIds = 1,2,3
     * @param string $onlyNew
     * @param string|null $geneNcbiIds
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function actionGetGeneInfo(string $onlyNew = 'true', string $geneNcbiIds = null)
    {
        $onlyNew = filter_var($onlyNew, FILTER_VALIDATE_BOOLEAN);
        $geneNcbiIdsArray = $geneNcbiIds ? explode(',', $geneNcbiIds) : [];

        /** @var ParseMyGeneServiceInterface $myGeneService */
        $myGeneService = \Yii::$container->get(ParseMyGeneServiceInterface::class);
        $myGeneService->parseInfo($onlyNew, $geneNcbiIdsArray);
    }

    /**
     * params: $onlyNew='true' $geneNcbiIds=1,2,3 $countRows=1000
     * @param string $onlyNew
     * @param string|null $geneNcbiIds
     * @param int $countRows
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function actionGetGoTerms(string $onlyNew='true', string $geneNcbiIds=null, int $countRows=1000)
    {
        $onlyNew = filter_var($onlyNew, FILTER_VALIDATE_BOOLEAN);
        /** @var GeneOntologyServiceInterface $geneOntologyService */
        $geneOntologyService = \Yii::$container->get(GeneOntologyServiceInterface::class);
        $arGenesQuery = \app\models\Gene::find()->where('gene.ncbi_id > 0');
        if($onlyNew) {
            $arGenesQuery->leftJoin('gene_to_ontology', 'gene_to_ontology.gene_id=gene.id')
                ->andWhere('gene_to_ontology.gene_id is null');
        }
        if($geneNcbiIds) {
            $arGenesQuery->andWhere(['in', 'gene.ncbi_id', explode(',', $geneNcbiIds)]);
        }
        $arGenes = $arGenesQuery->all();
        foreach ($arGenes as $arGene) {
            echo "{$arGene->id} {$arGene->ncbi_id} {$arGene->symbol}: ";
            try {
                $result = $geneOntologyService->mineFromGatewayForGene($arGene->ncbi_id, $countRows);
                if (isset($result['link_errors'])) {
                    echo ' ERROR ' . $result['link_errors'];
                    continue;
                }
                echo ' ok' . PHP_EOL;
            } catch (\Exception $e) {
                echo ' ERROR ' . $e->getMessage();
            }
        }
        echo PHP_EOL;
    }

}