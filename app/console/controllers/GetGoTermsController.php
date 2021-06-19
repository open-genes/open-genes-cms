<?php


namespace app\console\controllers;


use app\models\common\Gene;
use app\service\GeneOntologyServiceInterface;
use yii\console\Controller;

class GetGoTermsController extends Controller
{
    public function actionOntologyMineGene($id)
    {
        /** @var GeneOntologyServiceInterface $geneOntologyService */
        $geneOntologyService = \Yii::$container->get(GeneOntologyServiceInterface::class);
        return $geneOntologyService->mineFromGatewayForGene((int) $id);
    }



}