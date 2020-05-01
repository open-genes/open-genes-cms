<?php
namespace genes\controllers;

use common\components\CrossService;
use common\models\Gene;
use common\models\GeneOntology;
use common\models\GeneToOntology;
use genes\application\service\GeneInfoServiceInterface;
use genes\application\service\PhylumInfoServiceInterface;
use genes\application\service\GeneOntologyServiceInterface;
use genes\helpers\LanguageMapHelper;
use Yii;
use yii\db\Exception;
use yii\filters\Cors;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class ApiController extends Controller
{
    /** @var string */
    private $language;

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

    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $language = Yii::$app->request->getQueryParam('lang', 'en-US');
        $this->language = (new LanguageMapHelper())->getMappedLanguage($language);
        return parent::beforeAction($action);
    }

    public function actionReference()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;
        return $this->render('reference');
    }

    public function actionIndex()
    {
        /** @var GeneInfoServiceInterface $geneInfoService */
        $geneInfoService = Yii::$container->get(GeneInfoServiceInterface::class);
        $geneDtos = $geneInfoService->getAllGenes(null, $this->language);
        return $geneDtos;
    }

    /**
     * @param string $symbol
     * @return \genes\application\dto\GeneFullViewDto
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function actionGene($symbol)
    {
        /** @var GeneInfoServiceInterface $geneInfoService */
        $geneInfoService = Yii::$container->get(GeneInfoServiceInterface::class);
        $geneDto = $geneInfoService->getGeneViewInfo($symbol, $this->language);
        return $geneDto;
    }

    public function actionLatest()
    {
        /** @var GeneInfoServiceInterface $geneInfoService */
        $geneInfoService = Yii::$container->get(GeneInfoServiceInterface::class);
        return $geneInfoService->getLatestGenes(4, $this->language);
    }

    public function actionByFunctionalCluster($ids)
    {
        $functionalClusterIds = explode(',', $ids);
        /** @var GeneInfoServiceInterface $geneInfoService */
        $geneInfoService = Yii::$container->get(GeneInfoServiceInterface::class);
        return $geneInfoService->getByFunctionalClustersIds($functionalClusterIds, $this->language);
    }

    public function actionByExpressionChange($expressionChange)
    {
        /** @var GeneInfoServiceInterface $geneInfoService */
        $geneInfoService = Yii::$container->get(GeneInfoServiceInterface::class);
        return $geneInfoService->getByExpressionChange((int)$expressionChange, $this->language);
    }

    public function actionPhyla()
    {
        /** @var PhylumInfoServiceInterface $phylumInfoService */
        $phylumInfoService = Yii::$container->get(PhylumInfoServiceInterface::class);
        return $phylumInfoService->getAllPhyla();
    }

    /**
     * todo: ВНИМАНИЕ! Это только для тестов! Нужно перенести в консольное приложение и декомпозировать
     */
    public function actionOntologyMine()
    {
        /** @var GeneOntologyServiceInterface $geneOntologyService */
        $geneOntologyService = Yii::$container->get(GeneOntologyServiceInterface::class);
        return $geneOntologyService->mineFromGateway();
    }

    /**
     * todo: ВНИМАНИЕ! Это только для тестов! Нужно перенести в консольное приложение и декомпозировать
     */
    public function actionOntology()
    {
        /** @var GeneOntologyServiceInterface $geneOntologyService */
        $geneOntologyService = Yii::$container->get(GeneOntologyServiceInterface::class);
        return $geneOntologyService->getAllWithGenes();
    }

    /**
     * todo: ВНИМАНИЕ! Это только для тестов! Нужно перенести в консольное приложение и декомпозировать
     */
    public function actionOntologyGene($id)
    {
        /** @var GeneOntologyServiceInterface $geneOntologyService */
        $geneOntologyService = Yii::$container->get(GeneOntologyServiceInterface::class);
        return $geneOntologyService->getForGene($id);
    }

    /**
     * todo: ВНИМАНИЕ! Это только для тестов! Нужно перенести в консольное приложение и декомпозировать
     */
    public function actionOntologyMineGene($id)
    {
        /** @var GeneOntologyServiceInterface $geneOntologyService */
        $geneOntologyService = Yii::$container->get(GeneOntologyServiceInterface::class);
        return $geneOntologyService->mineFromGatewayForGene((int) $id);
    }

}
