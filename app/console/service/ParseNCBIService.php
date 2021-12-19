<?php


namespace app\console\service;


use app\models\common\GeneExpressionInSample;
use app\models\Gene;
use app\models\GeneToOrthologs;
use app\models\ModelOrganism;
use app\models\Orthologs;
use app\models\Sample;
use yii\helpers\Console;
use yii\helpers\VarDumper;
use yii\httpclient\Client;

class ParseNCBIService implements ParseNCBIServiceInterface
{
    private $apiUrl;

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

    public function parseOrthologs()
    {
        $orthologs = Orthologs::find()->all();
        if (!empty($orthologs)) {
            Console::output('table orthologs already filled!');
            return;
        }

        $geneToOrtholog = GeneToOrthologs::find()->all();
        if (!empty($geneToOrtholog)) {
            Console::output('table gene_to_orthologs already filled!');
            return;
        }

        $genes = Gene::find()->orderBy('id')->all();
        $organisms = ModelOrganism::find()->all();
        $httpClient = new Client();

        foreach ($organisms as $organism) {
            $organismNames[] = $organism->name_lat;
        }

        $count = 0;
        foreach ($genes as $gene) {
            try {
                foreach ($organisms as $organism) {
                    //птицы не нужны
                    if ($organism->name_en == 'birds') {
                        continue;
                    }
                    $organismQuery = '&taxon_filter=' . rawurlencode($organism->name_lat);
                    $url = "https://api.ncbi.nlm.nih.gov/datasets/v1/gene/id/{$gene->ncbi_id}/orthologs?returned_content=COMPLETE" . $organismQuery;
                    $response = $httpClient->createRequest()
                        ->setUrl($url)
                        ->send();
                    $parsedResult = json_decode($response->content, true);
                    if (!empty($parsedResult['message'])) {
                        continue;
                    }
                    if (!empty($parsedResult['genes']['messages'])) {
                        continue;
                    }
                    $genesApi = $parsedResult['genes']['genes'];
                    if (!is_array($genesApi)) {
                        continue;
                    }
                    foreach ($genesApi as $geneApi) {
                        //если у нас такого организма еще нет, добавим его
                        if (!in_array($geneApi['gene']['taxname'], $organismNames)) {
                            $newOrganism = new ModelOrganism();
                            $newOrganism->name_lat = $geneApi['gene']['taxname'];
                            if ($newOrganism->save()) {
                                Console::output('Add new organism ' . $geneApi['gene']['taxname']);
                                $organismNames[] = $newOrganism->name_lat;
                            }
                            $organism = $newOrganism;
                        }
                        $ortholog = new Orthologs();
                        $ortholog->symbol = $geneApi['gene']['symbol'];
                        $ortholog->model_organism_id = $organism->id;
                        if ($ortholog->save()) {
                            Console::output(
                                'New ortholog for organism ' . $organism->name_lat . ' successfully added, id ' . $ortholog->id
                            );
                        }

                        $geneToOrtholog = new GeneToOrthologs();
                        $geneToOrtholog->gene_id = $gene->id;
                        $geneToOrtholog->ortholog_id = $ortholog->id;
                        if ($geneToOrtholog->save()) {
                            Console::output(
                                'Relation gene to ortholog successfully created, ' . $gene->symbol . '->' . $geneApi['gene']['symbol']
                            );
                        }
                    }
                }
                sleep(1);

            } catch (\Exception $e) {
                Console::output($e->getMessage());
            }
            $count++;
            Console::output('Processed genes: ' . $count . ', last gene id ' . $gene->id);
        }
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