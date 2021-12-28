<?php


namespace app\console\controllers;


use app\console\service\ParseDiseasesServiceInterface;
use app\console\service\ParseICDServiceInterface;
use app\console\service\ParseMyGeneServiceInterface;
use app\console\service\ParseNCBIServiceInterface;
use app\console\service\ParseProteinAtlasServiceInterface;
use app\models\AgingMechanism;
use app\models\AgingMechanismToGeneOntology;
use app\models\common\GeneOntology;
use app\models\common\GeneToOntology;
use app\models\Disease;
use app\models\Gene;
use app\models\GeneOntologyRelation;
use app\models\GeneOntologyToAgingMechanismVisible;
use app\models\GeneToOrthologs;
use app\models\ModelOrganism;
use app\models\Orthologs;
use app\service\GeneOntologyServiceInterface;
use yii\console\Controller;
use yii\helpers\Console;
use yii\helpers\Html;
use yii\httpclient\Client;

class GetDataController extends Controller
{
    private const MAX_GENE = 100;
    private const NCBI_LIMIT = 10;

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
     */
    public function actionGetOrthologs($geneIdsAfter = 0)
    {
        $genesCount = Gene::find()->orderBy('id')->where(['>', 'id', $geneIdsAfter])->count();
        $count = 0;
        do {
            $consoleDir = \Yii::getAlias('@app/console');
            $handle = popen("php {$consoleDir}/yii.php get-data/get-orthologs-inner {$geneIdsAfter}", 'r');
            while ($output = fgets($handle)) {
                echo $output;
                if (preg_match('~Processed genes: (\d+)~', $output, $match)) {
                    $count += $match[1];
                }

                if (!preg_match('~last gene id (\d+)~', $output, $match)) {
                    continue;
                }
                $geneIdsAfter = $match[1];
            }
            Console::output('Total processed genes: ' . ($count) . '/' . $genesCount . ', last gene id ' . $geneIdsAfter);

        } while ($geneIdsAfter);

    }

    public function actionGetOrthologsInner($geneIdsAfter = 0)
    {
        /** @var  ParseNCBIServiceInterface $ncbiService */
        $ncbiService = \Yii::$container->get(ParseNCBIServiceInterface::class);
        $count = 0;
        try {
            do {
                $geneIdsAfter = $ncbiService->parseOrthologs($geneIdsAfter, self::NCBI_LIMIT);
                $count += self::NCBI_LIMIT;
                Console::output('INNER Processed genes: ' . self::NCBI_LIMIT . '(' . $count . '/' . self::MAX_GENE . '), last gene id ' . $geneIdsAfter);

            } while ($geneIdsAfter && $count < self::MAX_GENE);
        } catch (\Exception $e) {
            Console::output($e->getMessage());
        }

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
    public function actionGetGoTerms(string $onlyNew = 'true', string $geneNcbiIds = null, int $countRows = 1000)
    {
        $onlyNew = filter_var($onlyNew, FILTER_VALIDATE_BOOLEAN);
        /** @var GeneOntologyServiceInterface $geneOntologyService */
        $geneOntologyService = \Yii::$container->get(GeneOntologyServiceInterface::class);
        $arGenesQuery = Gene::find()->where('gene.ncbi_id > 0');
        if ($onlyNew) {
            $arGenesQuery->leftJoin('gene_to_ontology', 'gene_to_ontology.gene_id=gene.id')
                ->andWhere('gene_to_ontology.gene_id is null');
        }
        if ($geneNcbiIds) {
            $arGenesQuery->andWhere(['in', 'gene.ncbi_id', explode(',', $geneNcbiIds)]);
        }
        $arGenes = $arGenesQuery->all();
        $counter = 1;
        $count = count($arGenes);
        foreach ($arGenes as $arGene) {
            echo "{$arGene->id} {$arGene->ncbi_id} {$arGene->symbol} ({$counter} from {$count}): ";
            try {
                $result = $geneOntologyService->mineFromGatewayForGene($arGene->ncbi_id, $countRows);
                if (isset($result['link_errors'])) {
                    echo ' ERROR ' . $result['link_errors'];
                    continue;
                }
                echo ' ok' . PHP_EOL;
                $counter++;
            } catch (\Exception $e) {
                echo ' ERROR ' . $e->getMessage();
            }
        }
        echo PHP_EOL;
    }

    public function actionGetIcdTree($onlyNew = 'true')
    {
        $onlyNew = filter_var($onlyNew, FILTER_VALIDATE_BOOLEAN);

        /** @var  ParseICDServiceInterface $icdService */
        $icdService = \Yii::$container->get(ParseICDServiceInterface::class);
        $icdService->getICDTree($onlyNew);
    }

    public function actionGetIcdCodes() // todo temp
    {
        $httpClient = new Client();
        $diseases = Disease::find()->where('name_en is not null and (icd_code is null or icd_code="")')->all();
        echo PHP_EOL;
        $found = 0;
        foreach ($diseases as $disease) {
            echo $disease->name_en . ' ' . $disease->omim_id . ' ';
            $byOMIMResult = $httpClient->createRequest()
                ->setUrl("https://api.orphacode.org/EN/ClinicalEntity/FindbyOMIM/{$disease->omim_id}")
                ->setHeaders(['apiKey' => 'test'])
                ->send();
            $parsedResult = json_decode($byOMIMResult->content, true);
            $orhanetId = $parsedResult['References'][0]['ORPHAcode'] ?? null;
            if ($orhanetId) {
                echo $orhanetId . ' ';
                $icdResult = $httpClient->createRequest()
                    ->setUrl("https://api.orphacode.org/EN/ClinicalEntity/orphacode/{$orhanetId}/ICD10")
                    ->setHeaders(['apiKey' => 'test'])
                    ->send();
                $parsedResult = json_decode($icdResult->content, true);
                $icdId = $parsedResult['References'][0]['Code ICD10'] ?? null;
                if ($icdId) {
                    echo $icdId . ' found ';
                    $disease->icd_code = trim($icdId);
                    $disease->save();
                    $found++;
                    echo $found;
                }
            }
            echo PHP_EOL;
            usleep(100000);
        }
    }
    
    public function actionGetGoTree($onlyNew = 'true')
    {
        $onlyNew = filter_var($onlyNew, FILTER_VALIDATE_BOOLEAN);
        $httpClient = new Client();
        $termsWithAgingMechanisms = GeneOntology::find()
            ->select(['gene_ontology.id', 'gene_ontology.ontology_identifier', 'category'])
            ->innerJoin('aging_mechanism_to_gene_ontology', 'gene_ontology.id=aging_mechanism_to_gene_ontology.gene_ontology_id')
            ->distinct()
            ->asArray()
            ->all();
        
        $counter = 1;
        $total = count($termsWithAgingMechanisms);
        foreach ($termsWithAgingMechanisms as $goTerm) {
            $this->getGoChildren($httpClient, $goTerm, $goTerm['ontology_identifier'], $counter, $total, $onlyNew);
            $counter++;
        }
    }
    
    private function getGoChildren($httpClient, array $goTerm, $rootTermIdentifier, $rootTermCounter, $totalRootCount, $onlyNew)
    {
        echo "for root {$rootTermIdentifier} ({$rootTermCounter} by {$totalRootCount}) search children for {$goTerm['ontology_identifier']}" . PHP_EOL;
        $termChildrenFromAPI = $httpClient->createRequest()
            ->setUrl("https://www.ebi.ac.uk/QuickGO/services/ontology/go/terms/{$goTerm['ontology_identifier']}/children")
            ->send();

        $termChildren = json_decode($termChildrenFromAPI->content, true);
        if (isset($termChildren['results'][0]['children'])) {
            $goChildren = $termChildren['results'][0]['children'];

            foreach ($goChildren as $goChild) {
                if ($goChild['relation'] == 'is_a') {
                    echo 'found ' . $goChild['id'] . PHP_EOL;
                    $goTermChild = GeneOntology::find()
                        ->where(['ontology_identifier' => $goChild['id']])
                        ->one();
                    if (!$goTermChild) {
                        $goTermChild = new GeneOntology();
                        $goTermChild->ontology_identifier = $goChild['id'];
                        $goTermChild->name_en = $goChild['name'];
                        $goTermChild->category = $goTerm['category'];  // todo category??
                        $goTermChild->save();
                        $goTermChild->refresh();
                    }

                    $termsRelation = GeneOntologyRelation::find()
                        ->where([
                            'gene_ontology_id' => $goTermChild->id,
                            'gene_ontology_parent_id' => $goTerm['id']
                        ])
                        ->one();
                    if($termsRelation && $onlyNew) {
                        continue;
                    }
                    if (!$termsRelation) {
                        $termsRelation = new GeneOntologyRelation();
                        $termsRelation->gene_ontology_id = $goTermChild->id;
                        $termsRelation->gene_ontology_parent_id = $goTerm['id'];
                        $termsRelation->save();
                    }
                    if($goChild['hasChildren']) {
                        $goTermChild = $goTermChild->toArray();
                        $this->getGoChildren($httpClient, $goTermChild, $rootTermIdentifier, $rootTermCounter, $totalRootCount, $onlyNew);
                    }
                }
            }
        }
    }
    
    public function actionUpdateGoToAgingMechanisms()
    {
        $activeGoTermsIdsWithGenes = GeneToOntology::find()
            ->select('gene_ontology_id')
            ->distinct()
            ->column();

        foreach ($activeGoTermsIdsWithGenes as $goTermId) {
            echo "search parents for {$goTermId} ";
            $goTermParentsIds = $this->getGoParents($goTermId);
            if($goTermParentsIds) {
                echo ' - found ' . count($goTermParentsIds); 
            }
            echo PHP_EOL;
            
            $goTermsIds = array_merge([$goTermId], $goTermParentsIds);
            echo 'search aging mechanisms for ' . implode($goTermsIds, ', ');
            $agingMechanismsIds = AgingMechanismToGeneOntology::find()
                ->select('aging_mechanism_id')
                ->distinct()
                ->where(['gene_ontology_id' => $goTermsIds])
                ->column();
            echo ' found ' . count($agingMechanismsIds) . PHP_EOL;
            /** @var GeneOntologyToAgingMechanismVisible[] $currentVisibleAgingMechanisms */
            $currentVisibleAgingMechanisms = GeneOntologyToAgingMechanismVisible::find()
                ->where(['gene_ontology_id' => $goTermId])
                ->all();
            $currentVisibleAgingMechanismsIds = [];
            $deleted = 0;
            $added = 0;
            foreach ($currentVisibleAgingMechanisms as $visibleAgingMechanism) {
                $currentVisibleAgingMechanismsIds[] = $visibleAgingMechanism->aging_mechanism_id;
                if (!in_array( $visibleAgingMechanism->aging_mechanism_id, $agingMechanismsIds)) {
                    $visibleAgingMechanism->delete();
                    $deleted++;
                } 
            }
            $toAdd = array_diff($agingMechanismsIds, $currentVisibleAgingMechanismsIds);
            foreach ($toAdd as $id) {
                $newVisibleMechanism = new GeneOntologyToAgingMechanismVisible();
                $newVisibleMechanism->gene_ontology_id = $goTermId;
                $newVisibleMechanism->aging_mechanism_id = $id;
                $newVisibleMechanism->save();
                $added++;
            }
            echo " {$deleted} deleted, {$added} added" . PHP_EOL;
        }
    }
    
    private function getGoParents($goTermId, $parents = [])
    {
        $foundParentsIds = GeneOntologyRelation::find()
            ->select('gene_ontology_parent_id')
            ->where(['gene_ontology_id' => $goTermId])
            ->column();
        $parents = array_merge($parents, $foundParentsIds);
        if ($foundParentsIds) {
            foreach ($foundParentsIds as $foundParentId) {
                $parents = array_unique(array_merge($parents, $this->getGoParents($foundParentId, $parents)));
            }
        }
        return $parents;
    }

}