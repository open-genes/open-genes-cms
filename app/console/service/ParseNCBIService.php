<?php


namespace app\console\service;


use app\models\common\GeneExpressionInSample;
use app\models\Gene;
use app\models\GeneToOrthologs;
use app\models\ModelOrganism;
use app\models\Orthologs;
use app\models\Sample;
use Yii;
use yii\helpers\Console;
use yii\helpers\VarDumper;
use yii\httpclient\Client;
use yii\httpclient\Response;

class ParseNCBIService implements ParseNCBIServiceInterface
{
    private $apiUrl;
    private const API_KEY = '75dc1a57e62b6ec836138c808c26f9944808';

    public function __construct($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    public function parseExpression(bool $onlyNew=true, array $geneNcbiIdsArray=[])
    {
        $arGenesQuery = Gene::find()->where('gene.symbol is not null');
        if($onlyNew) {
            $arGenesQuery->leftJoin('gene_expression_in_sample', 'gene_expression_in_sample.gene_id=gene.id')
                ->andWhere('gene_expression_in_sample.gene_id is null');
        }
        if($geneNcbiIdsArray) {
            $arGenesQuery->andWhere(['in', 'gene.ncbi_id', $geneNcbiIdsArray]);
        }
        $arGenes = $arGenesQuery->all();
        $counter = 1;
        $count = count($arGenes);
        $client = new Client();
        foreach ($arGenes as $arGene) {
            try {
                if (strtoupper($arGene->symbol)  !== $arGene->symbol) {
                    echo 'not human gene ' . $arGene->symbol . PHP_EOL;
                    continue;
                }
                echo 'parsing info for gene id=' . $arGene->id . ' ncbi_id=' . $arGene->ncbi_id . ' (' . $counter . ' from ' . $count . ') ... ';
                $url = $this->apiUrl . 'gene/' . $arGene->ncbi_id . '/expression/details?p$l=Expression';
                $geneInfoPage = $response = $client->createRequest()
                    ->setUrl($url)
                    ->setFormat(Client::FORMAT_JSON)
                    ->send();
                if (!$response->isOk) {
                    echo $response->getStatusCode();
                }
                $geneExpression = $this->parseExpressionFromPage($geneInfoPage);
                foreach ($geneExpression as $sample => $expressionValues) {
                    echo $sample . ' ';
                    $sample = str_replace(" adult", "", $sample);
                    $arSample = Sample::find()
                        ->andWhere(['name_en' => $sample])
                        ->one();
                    if (!$arSample) {
                        $arSample = new Sample();
                        $arSample->name_en = $sample;
                        $arSample->save();
                        $arSample->refresh();
                    }
                    $arGeneExpressionSample = GeneExpressionInSample::find()
                        ->andWhere(['gene_id' => $arGene->id])
                        ->andWhere(['sample_id' => $arSample->id])
                        ->one();
                    if (!$arGeneExpressionSample) {
                        $arGeneExpressionSample = new GeneExpressionInSample();
                        $arGeneExpressionSample->gene_id = $arGene->id;
                        $arGeneExpressionSample->sample_id = $arSample->id;
                    }
                    $arGeneExpressionSample->expression_value = $expressionValues['full_rpkm'];
                    $arGeneExpressionSample->save();
                }
                echo 'success' . PHP_EOL;
                sleep(2);
            } catch (\Exception $e) {
                echo PHP_EOL . 'ERROR ' . $e->getMessage() . ' url: ' . $url . PHP_EOL;
            }
            $counter++;
        }
    }

    public function parseOrthologs($geneId)
    {
        $genes = Gene::find()->orderBy('id')->where(['>=', 'id', $geneId])->all();

        //птицы и клеточные культуры не нужны
        $organisms = ModelOrganism::find()->where(
            ['not', ['name_en' => 'birds']]
        )->andWhere(['not', ['name_en' => 'cell culture']])->all();

        $organismQuery = '';
        $organismsNamed = [];
        foreach ($organisms as $organism) {
            $organismQuery .= '&taxon_filter=' . rawurlencode($organism->name_lat);
            $organismsNamed[$organism->name_lat] = $organism;
        }

        $count = 0;
        $httpClient = new Client([
            'transport' => 'yii\httpclient\CurlTransport'
        ]);

        $requests = [];
        $genesNamed = [];
        foreach ($genes as $gene) {
            try {
                $mem = memory_get_usage();
                $genesNamed[$gene->ncbi_id] = $gene;
                $url = "https://api.ncbi.nlm.nih.gov/datasets/v1/gene/id/{$gene->ncbi_id}/orthologs?api_key=". self::API_KEY . "&returned_content=COMPLETE" . $organismQuery;
                $requests[$gene->ncbi_id] = $httpClient->get($url);
                if (count($requests) > 9 || $count == count($genes) - 1) {
                    $responses = $httpClient->batchSend($requests);
                    foreach ($responses as $ncbi_id => $response) {
                        $this->parseGeneForOrthologs($genesNamed[$ncbi_id], $response, $organismsNamed);
                    }
                    $requests = [];
                    $genesNamed = [];
                    $conv = function ($size)
                    {
                        $unit=array('b','kb','mb','gb','tb','pb');
                        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
                    };
                    gc_collect_cycles();
                    $memUsage = memory_get_usage();
                    Console::output('Processed genes: ' . ($count + 1) . '/' . count($genes) . ', Memory: ' . $conv($memUsage). ', last gene id ' . $gene->id);
                }

            } catch (\Exception $e) {
                Console::output($e->getMessage());
            }
            $count++;
        }
        Console::output('Done! Total:' . count($genes));
    }

    /**
     * @param $gene Gene
     * @param string $organismQuery
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    private function parseGeneForOrthologs(Gene $gene, Response $response, array &$organismsNamed)
    {
        $parsedResult = json_decode($response->content, true);
        if (!empty($parsedResult['message'])) {
            return;
        }
        if (!empty($parsedResult['genes']['messages'])) {
            return;
        }
        $genesApi = $parsedResult['genes']['genes'];
        if (!is_array($genesApi)) {
            return;
        }
        foreach ($genesApi as $geneApi) {
            $organism = $organismsNamed[$geneApi['gene']['taxname']] ?? null;
            if ($organism == null) {
                $organism = $this->createNewOrganism($geneApi['gene']['taxname']);
                $organismsNamed[$geneApi['gene']['taxname']] = $organism;
            }

            $ortholog = new Orthologs();
            $ortholog->symbol = $geneApi['gene']['symbol'];
            $ortholog->model_organism_id = $organism->id;
            if ($ortholog->save()) {
                Yii::info('New ortholog for organism ' . $organism->name_lat . ' successfully added, id ' . $ortholog->id);
            }

            $geneToOrtholog = new GeneToOrthologs();
            $geneToOrtholog->gene_id = $gene->id;
            $geneToOrtholog->ortholog_id = $ortholog->id;
            if ($geneToOrtholog->save()) {
                Yii::info('Relation gene to ortholog successfully created, ' . $gene->symbol . '->' . $geneApi['gene']['symbol']);
            }

        }
    }

    private function createNewOrganism(string $taxname): ModelOrganism {
        $newOrganism = new ModelOrganism();
        $newOrganism->name_lat = $taxname;
        if ($newOrganism->save()) {
            Yii::info('Add new organism ' . $taxname);
        }
        return $newOrganism;
    }

    /**
     * @param string $geneInfoPage
     * @return array
     * @throws \Exception
     */
    private function parseExpressionFromPage(string $geneInfoPage): array
    {
        preg_match('/tissues_data = ({.*});/', $geneInfoPage, $result);
        $expressionDataString = $result[1] ?? '';
        $expressionDataJson = str_replace("'", "\"", $expressionDataString);
        $expressionArray = json_decode($expressionDataJson, true);
        if(is_array($expressionArray)) {
            $resultArray = [];
            foreach($expressionArray as $name => $expressionValues) {
                if(isset($expressionValues['exp_rpkm'])) {
                    if($expressionValues['exp_rpkm'] > 0) {
                        $resultArray[$name]['full_rpkm'] = $expressionValues['full_rpkm'];
                        $resultArray[$name]['exp_rpkm'] = $expressionValues['exp_rpkm'];
                        $resultArray[$name]['var'] = $expressionValues['var'];
                        $resultArray[$name]['project_desc'] = $expressionValues['project_desc'];
                    }
                } else {
                    throw new \Exception('Couldn\'t parse gene info, $expressionArray = ' . var_export($expressionArray, true));
                }
            }
            uasort( $resultArray, function ($item1, $item2) {
                return $item2['exp_rpkm'] <=> $item1['exp_rpkm'];
            });
        } else {
            throw new \Exception('Couldn\'t parse gene info');
        }
        return $resultArray;
    }
}