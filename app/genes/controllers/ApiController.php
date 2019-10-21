<?php
namespace genes\controllers;

use genes\application\service\GeneInfoServiceInterface;
use genes\helpers\LanguageMapHelper;
use Yii;
use yii\base\Widget;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class ApiController extends Controller
{
    public function init()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        parent::init();
    }

    public function actionIndex($lang = 'en-US')
    {
        $language = (new LanguageMapHelper())->getMappedLanguage($lang);
        /** @var GeneInfoServiceInterface $geneInfoService */
        $geneInfoService = Yii::$container->get(GeneInfoServiceInterface::class);
        $geneDtos = $geneInfoService->getAllGenes(null, $language);
        return $geneDtos;
    }

}
