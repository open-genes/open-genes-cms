<?php
namespace genes\controllers;

use genes\application\service\GeneInfoServiceInterface;
use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class GeneController extends Controller
{

    public function actionIndex($gene)
    {
        /** @var GeneInfoServiceInterface $geneInfoService */
        $geneInfoService = Yii::$container->get(GeneInfoServiceInterface::class);
        $geneDto = $geneInfoService->getGeneViewInfo((int)$gene);
        return $this->render('index', ['gene' => $geneDto]);
    }

}
