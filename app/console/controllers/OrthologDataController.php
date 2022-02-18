<?php

namespace app\console\controllers;

use app\console\service\ParseOrthologServiceInterface;
use Yii;
use yii\console\Controller;

class OrthologDataController extends Controller
{
    public function behaviors()
    {
        return parent::behaviors();
    }

    public function actionOrthologToLifespan()
    {
        $sql = 'UPDATE lifespan_experiment le
                JOIN gene_to_orthologs gto ON le.gene_id = gto.gene_id
                JOIN orthologs o ON gto.ortholog_id = o.id
                SET le.ortholog_id = o.id
                WHERE le.model_organism_id = o.model_organism_id';
        Yii::$app->db->createCommand($sql)->execute();
    }

    public function actionHumanGeneFromGeneageFlies($geneAgeData, $fybaseData)
    {
        if (!file_exists($geneAgeData)) {
            return 'Cannot find geneage data file';
        }
        if (!file_exists($fybaseData)) {
            return 'Cannot find flybase data file';
        }
        /** @var ParseOrthologServiceInterface $orthologService */
        $orthologService = \Yii::$container->get(ParseOrthologServiceInterface::class);
        return $orthologService->parseHumanGeneFromGeneageFlies($geneAgeData, $fybaseData);
    }

    public function actionHumanGeneFromGeneageMice($geneAgeData)
    {
        if (!file_exists($geneAgeData)) {
            return 'Cannot find geneage data file';
        }
        /** @var ParseOrthologServiceInterface $orthologService */
        $orthologService = \Yii::$container->get(ParseOrthologServiceInterface::class);

        return $orthologService->parseHumanGeneFromGeneageMice($geneAgeData);
    }

    public function actionImportOrthologsFromFlybase($absolutePathToFile)
    {
        if (!file_exists($absolutePathToFile)) {
            return 'Cannot find data file';
        }
        /** @var ParseOrthologServiceInterface $orthologService */
        $orthologService = \Yii::$container->get(ParseOrthologServiceInterface::class);
        return $orthologService->parseOrthologsFromFlybase($absolutePathToFile);
    }

    public function actionImportOrthologsFromFlybaseInner($params)
    {
        /** @var ParseOrthologServiceInterface $orthologService */
        $orthologService = \Yii::$container->get(ParseOrthologServiceInterface::class);
        $orthologService->parseOrthologsFromFlybaseInner($params);
    }
}