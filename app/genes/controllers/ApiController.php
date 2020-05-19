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

    /**
     * todo: ВНИМАНИЕ! Это только для тестов! Нужно перенести в консольное приложение и декомпозировать
     */
    public function actionHumanProteinMineGene()
    {
        /** @var GeneOntologyServiceInterface $geneOntologyService */
        //todo: добавить это в params.php
        Yii::$app->params['servicesPath']['humanprotein'] = 'https://www.proteinatlas.org';

        // ENSG for Gene
        // by symbol
        // form https://www.proteinatlas.org/search/A2M?format=json

        $result = [
            'errors' => [],
            'errorsGetENSG' => [],
            'errorsGeneSave' => [],
        ];

        $genes = Gene::find()->all();

        foreach ($genes as $gene) {

            $genesJson = file_get_contents('https://www.proteinatlas.org/search/'.$gene->symbol.'?format=json');

            if ($genesJson == '[]') {
                $result['errorsGetENSG'][] = '404 for gene :' . $gene->symbol;
                continue;
            }

            $geneResult = (array)json_decode($genesJson, true)[0];

            var_dump($geneResult['Ensembl']);

            $gene->ensembl = $geneResult["Ensembl"]; //"ENSG00000175899"

            if (!$gene->save()) {
                $result['errorsGetENSG'][] = [$gene->symbol => $gene->errors];
            } else {
                continue;


                /**
                 * MAPPER
                 * Общие вопросы: Summary, Protein information, Gene information - это отдельные ендпоинты, отдельные таблицы? Как будут использоваться? Будет ли поиск по каждой отдельной такой категории?
                    Некоторые поля содержат вложенные данные. Они так же должны быть отдельными сущностями со своими таблицами? Или их хранить сразу в JSON? Или всё перечисленное будет использоваться только из этого ендпоинта только с фильтрацией по генц и это может быть один большой JSON (вряд ли)

                    Маппер полей:

                    Summary:

                    Tissue specificity - есть "RNA tissue specificity score": "5", "RNA tissue specificity": "Group enriched", - что из них?
                    Subcellular location - нужно так массивом и отдавать? Как будет использоваться? Нужно ли отдельное множество\таблица? "Subcellular location": ["Plasma membrane","Cytosol","Cytoplasmic bodies"],
                    Cancer prognostic summary - not found
                    Brain specificity - specificity, specificity score или specificity NX ????
                    Blood specificity - RNA blood cell specificity? И такой же вопрос как в Brain
                    Predicted location - есть другие location. Такого не нашел.
                    Protein function (UniProt) - "Uniprot": ["P10912"], array??
                    -Molecular function (UniProt) - "Molecular function" array??
                    Biological process (UniProt) - "Biological process" array??
                    Disease involvement - "Disease involvement" array?
                    Ligand (UniProt) - not found


                    Protein information:

                    Splice variant - not found
                    UniProt - Такое есть, но Summary тоже имеет такой
                    Protein class (у нас proteinClasses уже есть, но не по сплайсинговым вариантам) - "Protein class"
                    Gene Ontology (тоже есть, но нет terms по сплайсинговым вариантам гена) - not found
                    Length & mass (очень нужно, так как нам нужны физические характеристики белка) - not found
                    Signal peptide (predicted) - not found
                    Transmembrane regions (predicted) - not found


                    Gene information

                    Synonyms (добавить в наше поле aliases синонимы отсюда, если их недостает) - "Gene synonym" ?
                    Chromosome - "Chromosome"
                    Cytoband (есть из GeneAge, но у новых генов нет) ????
                    Chromosome location (bp) - not found
                    Number of transcripts - not found
                    neXtProt id - "NeXtProt evidence" - это не оно?
                    Antibodypedia id - not found
                 */
                $ensg = $gene->ensembl;
                $geneOntologyGateway = CrossService::requestGetGateway('humanprotein',
                    '/ENSG'.$ensg.'.json', []);

                $geneOntologyGateway->unsetJson();
                $geneOntologyGateway->unsetInnerRequest();

                $genesJson = $geneOntologyGateway->request();

                if ($geneOntologyGateway->status == 301) {
                    $result['errors'] = '301 for ENSG :' . $ensg;
                    return $result;
                }

                if ($geneOntologyGateway->status == 404) {
                    $result['errors'] = '404 for ENSG :' . $ensg;
                    return $result;
                }

                $genes = (array)json_decode($genesJson, true);
            }
        }

        return $result;
    }

}
