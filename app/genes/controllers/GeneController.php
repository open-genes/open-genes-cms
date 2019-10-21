<?php
namespace genes\controllers;

use genes\application\service\GeneInfoServiceInterface;
use Yii;
use yii\base\InvalidConfigException;
use yii\di\NotInstantiableException;
use yii\web\Controller;

/**
 * Gene controller
 */
class GeneController extends Controller
{
    /**
     * @param $gene
     * @return string
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     */
    public function actionIndex($gene)
    {
        /** @var GeneInfoServiceInterface $geneInfoService */
        $geneInfoService = Yii::$container->get(GeneInfoServiceInterface::class);
        $geneDto = $geneInfoService->getGeneViewInfo((int)$gene, Yii::$app->language);
        return $this->render('index', ['gene' => $geneDto]);
    }

}
