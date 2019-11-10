<?php
namespace genes\controllers;

use genes\application\service\GeneInfoServiceInterface;
use genes\helpers\LanguageMapHelper;
use Yii;
use yii\filters\Cors;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class ApiController extends Controller
{
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => Cors::class,
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'OPTIONS'],
                ],

            ],
        ];
    }

    public function actionReference()
    {
        return $this->render('reference');
    }

    public function actionIndex($lang = 'en-US')
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $language = (new LanguageMapHelper())->getMappedLanguage($lang);
        /** @var GeneInfoServiceInterface $geneInfoService */
        $geneInfoService = Yii::$container->get(GeneInfoServiceInterface::class);
        $geneDtos = $geneInfoService->getAllGenes(null, $language);
        return $geneDtos;
    }

}
