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
    
    public function actionByGoTerm($term)
    {
        /** @var GeneInfoServiceInterface $geneInfoService */
        // todo валидация
        $term = strip_tags(trim($term));
        if(strlen($term) < 3) {
            return [];
        }
        $geneInfoService = Yii::$container->get(GeneInfoServiceInterface::class);
        return $geneInfoService->getByGoTerm($term, $this->language);
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

    //todo: ВНИМАНИЕ! Это только для тестов! Нужно перенести в консольное приложение и декомпозировать

    /**
     * Цель алгоритма:   заполнить базу данными атласа (api/gene/ID -> gene.JSON:human_protein_atlas)
     * Источник данных:  https://www.proteinatlas.org/search/<<<SYMBOL>>>?format=json
     *
     * Ресурс работает в 2-х режимах:
     * Обновить всю базу атласа /api/human-protein-mine-gene
     * Скачать данные атласа только для новых генов /api/human-protein-mine-gene?onlyNew=1
     *
     * Ресурс поставляет данные в формате:
     *  info           - массив даннных о процессе обновления атласа. К примеру информация о том, что атлас уже существует (в спец. режиме)
     *  errorsGetENSG  - ошибки поиска гена в атласе
     *  errorsGeneSave - ошибки сохранения модели гена
     *  atlasMapper    - успешно сохраненные данные атласа
     *
     * @param bool $onlyNew
     * @return array
     */
    public function actionHumanProteinMineGene($onlyNew = false)
    {
        ini_set('max_execution_time', 9000);
        // ENSG for Gene
        // by symbol
        // form https://www.proteinatlas.org/search/A2M?format=json

        $result = [
            'info' => [],
            'errors' => [],
            'errorsGetENSG' => [],
            'errorsGeneSave' => [],
            'atlasMapper' => [],
        ];

        $genes = Gene::find()->all();

        foreach ($genes as $gene) {

            if ($onlyNew && !empty($gene->human_protein_atlas)) {
                $result['info'][] = $gene->id . ' Human Protein Atlas Is Not Empty: CONTINUE!';
                continue;
            }

            $genesJson = file_get_contents('https://www.proteinatlas.org/search/'.$gene->symbol.'?format=json');

            if ($genesJson == '[]') {
                $result['errorsGetENSG'][] = '404 for gene :' . $gene->symbol;
                continue;
            }

            $geneResult = (array)json_decode($genesJson, true)[0];

            if (!empty($gene->ensembl)) {
                $gene->ensembl = $geneResult["Ensembl"]; //"ENSG00000175899"
            }

            /*//todo: такая структура была в таске, но потом решили 1 в 1 сохранять. Пока оставляю на всякий случай, но если таск закрыт - можно удалять.
             * $geneAtlasMapper = [
                //"summary" => [
                "tissueSpecificity" => $geneResult['qweqwe'],
                "subcellularLocation" => $geneResult['qweqwe'],
                "cancerPrognosticSummary" => $geneResult['qweqwe'],
                "brainSpecificity" => $geneResult['qweqwe'],
                "bloodSpecificity" => $geneResult['qweqwe'],
                "predictedLocation" => $geneResult['qweqwe'],
                "proteinFunction" => $geneResult['qweqwe'],
                "molecularFunction" => $geneResult['qweqwe'],
                "biologicalProcess" => $geneResult['qweqwe'],
                "diseaseInvolvement" => $geneResult['qweqwe'],
                "ligand" => $geneResult['qweqwe'],
                //],
                //"proteinInformation" => [
                "spliceVariant" => $geneResult['qweqwe'],
                "uniProt" => $geneResult['qweqwe'],
                "proteinClass" => $geneResult['qweqwe'],
                "geneOntology" => $geneResult['qweqwe'],
                "lengthAndMass" => $geneResult['qweqwe'],
                "signalPeptide" => $geneResult['qweqwe'],
                "transmembraneRegions" => $geneResult['qweqwe'],
                //],
                //"geneInformation" => [
                "synonyms" => $geneResult['qweqwe'],
                "chromosome" => $geneResult['qweqwe'],
                "cytoband" => $geneResult['qweqwe'],
                "chromosomeLocation" => $geneResult['qweqwe'],
                "numberOfTranscripts" => $geneResult['qweqwe'],
                "neXtProtId" => $geneResult['qweqwe'],
                "antibodypediaId" => $geneResult['qweqwe'],
                //],
            ];*/

            if ($onlyNew && empty($gene->human_protein_atlas)) {
                $geneResult = $this->recursiveCamelCase($geneResult);
                $gene->human_protein_atlas = json_encode($geneResult);

                if (!$gene->save()) {
                    $result['errorsGeneSave'][] = $gene->errors;
                } else {
                    $result['atlasMapper'][$gene->id] = 'ok';//$gene->human_protein_atlas;
                }
            }
        }

        return $result;
    }

    //todo: Вынести в сервисный слой
    /**
     *
     * @param $items
     * @return array
     */
    public function recursiveCamelCase($items) {
        $newItems = [];
        foreach ($items as $k => $item) {
            //todo: это можно сделать одной функцией.
            $newKey = str_replace('-', ' ', $k);
            $newKey = str_replace(['_', '.', ',', '/', '[', ']', '(', ')',], ' ', $newKey);
            $newKey = ucwords($newKey);
            $newKey = str_replace(' ', '', $newKey);
            $newItems[$newKey] = $item;

            if (is_array($item)) {
                $newItems[$newKey] = $this->recursiveCamelCase($item);
            }
        }

        return $newItems;
    }
}
