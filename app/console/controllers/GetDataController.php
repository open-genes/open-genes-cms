<?php


namespace app\console\controllers;


use app\models\common\GeneExpressionInSample;
use app\models\common\GeneToDisease;
use app\models\common\GeneToProteinClass;
use app\models\Disease;
use app\models\Gene;
use app\models\ProteinClass;
use app\models\Sample;
use yii\base\BaseObject;
use yii\console\Controller;
use yii\httpclient\Client;

class GetDataController extends Controller
{
    /**
     * @param string $onlyNew
     * @param string|null $geneNcbiIds
     * @param string|null $geneSearchName
     */
    public function actionGetProteinClasses(string $onlyNew = 'true', string $geneNcbiIds = null, string $geneSearchName = null)
    {
        $onlyNew = filter_var($onlyNew, FILTER_VALIDATE_BOOLEAN);
        $apiUrl = 'https://www.proteinatlas.org/search/';
        $arGenesQuery = Gene::find()->where('gene.symbol is not null');
        if($onlyNew) {
            $arGenesQuery->leftJoin('gene_to_protein_class', 'gene_to_protein_class.gene_id=gene.id')
                ->andWhere('gene_to_protein_class.gene_id is null');
        }
        if($geneNcbiIds) {
            $geneNcbiIdsArray = explode(',', $geneNcbiIds);
            if($geneSearchName && count($geneNcbiIdsArray) > 1) {
                echo "We'll take only the first gene from array because of name given" . PHP_EOL;
                $geneNcbiIdsArray = [current($geneNcbiIdsArray)];
            }
            $arGenesQuery->andWhere(['in', 'gene.ncbi_id', $geneNcbiIdsArray]);
        }
        $arGenes = $arGenesQuery->all();
        $client = new Client();
        $counter = 1;
        $count =  count($arGenes);

        foreach ($arGenes as $arGene) {
            echo "{$arGene->id} {$arGene->ncbi_id} {$arGene->symbol} ({$counter} from {$count}): ";
            $searchGene = $geneSearchName ?? urlencode("{$arGene->ncbi_id} {$arGene->symbol}");
            try {
                $response = $client->createRequest()
                    ->setUrl("{$apiUrl}{$searchGene}?format=json&columns=g,pc")
                    ->setFormat(Client::FORMAT_JSON)
                    ->send();
                if (!$response->isOk) {
                    throw new \Exception('Failed with status code: ' . $response->getStatusCode());
                }
                if((int)$response->headers['content-length'] > 10000000) { // todo
                    throw new \Exception('Response is too big: ' . $response->headers['content-length']);
                }
                $parsedResponse = json_decode($response->content, true);

                foreach ($parsedResponse as $geneInfo) {
                    if ($geneInfo['Gene'] === $arGene->symbol) {
                        foreach ($geneInfo['Protein class'] as $proteinClass) {
                            $nameSearch = [
                                trim($proteinClass),
                                trim(str_replace('proteins', '', $proteinClass)),
                                trim(str_replace('genes', '', $proteinClass))
                            ];
                            $arProteinClass = ProteinClass::find()
                                ->where(['in', 'name_en', $nameSearch])
                                ->one();
                            if (!$arProteinClass) {
                                echo 'NOT FOUND ' . $proteinClass . ' ';
                                continue;
                            }
                            $arGeneToProteinClass = GeneToProteinClass::find()
                                ->where([
                                    'protein_class_id' => $arProteinClass->id,
                                    'gene_id' => $arGene->id,
                                ])
                                ->one();
                            if (!$arGeneToProteinClass) {
                                $arGeneToProteinClass = new GeneToProteinClass();
                                $arGeneToProteinClass->gene_id = $arGene->id;
                                $arGeneToProteinClass->protein_class_id = $arProteinClass->id;
                                $arGeneToProteinClass->save();
                            }
                            echo '"' . $arProteinClass->name_en . '" ';
                        }
                    }
                }
            } catch (\Exception $e) {
                echo PHP_EOL . 'ERROR ' . $e->getMessage() . ' url: ' . "{$apiUrl}{$searchGene}?format=json&columns=g,pc" . PHP_EOL;
            }
            $counter++;
            echo PHP_EOL;
        }
    }


    public function actionGetProteinAtlas(string $onlyNew = 'true', string $geneNcbiIds = null, string $geneSearchName = null)
    {
        $onlyNew = filter_var($onlyNew, FILTER_VALIDATE_BOOLEAN);
        $apiUrl = 'https://www.proteinatlas.org/search/';
        $arGenesQuery = Gene::find()->where('gene.symbol is not null');
        if ($onlyNew) {
            $arGenesQuery->andWhere('gene.human_protein_atlas is null');
        }
        if ($geneNcbiIds) {
            $geneNcbiIdsArray = explode(',', $geneNcbiIds);
            if ($geneSearchName && count($geneNcbiIdsArray) > 1) {
                echo "We'll take only the first gene from array because of name given" . PHP_EOL;
                $geneNcbiIdsArray = [current($geneNcbiIdsArray)];
            }
            $arGenesQuery->andWhere(['in', 'gene.ncbi_id', $geneNcbiIdsArray]);
        }

        $arGenes = $arGenesQuery->all();
        $client = new Client();
        $counter = 1;
        $count = count($arGenes);
        foreach ($arGenes as $arGene) {
            echo "{$arGene->id} {$arGene->ncbi_id} {$arGene->symbol} ({$counter} from {$count}): ";
            $searchGene = $geneSearchName ?? urlencode("{$arGene->ncbi_id} {$arGene->symbol}");
            try {
                $response = $client->createRequest()
                    ->setUrl("{$apiUrl}{$searchGene}?format=json")
                    ->setFormat(Client::FORMAT_JSON)
                    ->send();
                if (!$response->isOk) {
                    throw new \Exception('Failed with status code: ' . $response->getStatusCode());
                }
                if ((int)$response->headers['content-length'] > 10000000) { // todo
                    throw new \Exception('Response is too big: ' . $response->headers['content-length']);
                }
                $parsedResponse = (array)json_decode($response->content, true)[0];
                if (!$arGene->ensembl) {
                    $arGene->ensembl = $parsedResponse["Ensembl"]; //"ENSG00000175899"
                }
                $parsedResponse = $this->recursiveCamelCase($parsedResponse);
                $arGene->human_protein_atlas = json_encode($parsedResponse);
                $arGene->save();
            } catch (\Exception $e) {
                echo PHP_EOL . 'ERROR ' . $e->getMessage() . ' url: ' . "{$apiUrl}{$searchGene}?format=json&columns=g,pc" . PHP_EOL;
            }
            $counter++;
            echo PHP_EOL;
        }
    }


    public function actionGetDiseasesFromBiocomp()
    {
        $apiUrl = 'http://edgar.biocomp.unibo.it/gene_disease_db/csv_files/';
        $arGenes = Gene::find()
            ->all();
        $client = new Client();
        foreach ($arGenes as $arGene) {
            $response = $client->createRequest()
                ->setUrl($apiUrl . $arGene->symbol . '.csv')
                ->setFormat(Client::FORMAT_JSON)
                ->send();
            if (!$response->isOk) {
                echo $apiUrl . $arGene->symbol . '.csv response: ' . $response->getStatusCode() . PHP_EOL;
                continue;
            }

            preg_match('/#Gene-disease associations table(.*?)#/s', $response->content, $matches);
            $diseases = [];
            if (!$matches) {
                continue;
            }
            foreach (explode(PHP_EOL, $matches[1]) as $line) {
                if (!$line || $line[0] == '#' || $line[0] == null || str_starts_with($line, 'Disease ID')  ) {
                    continue;
                }
                $diseases[] = str_getcsv($line, "\t");
            }
            $saved = 0;
            foreach ($diseases as $diseaseArray) {
                $omimId = (int)filter_var($diseaseArray[0], FILTER_SANITIZE_NUMBER_INT);
                $arDisease = Disease::findOne(['omim_id' => $omimId]);
                if (!$arDisease) {
                    $arDisease = new Disease();
                    $arDisease->omim_id = $omimId;
                    $arDisease->name_en = ucfirst(strtolower($diseaseArray[1]));
                    $arDisease->save();
                    $arDisease->refresh();
                }
                $arGeneToDisease = GeneToDisease::findOne(['gene_id' => $arGene->id, 'disease_id' => $arDisease->id]);
                
                if (!$arGeneToDisease) {
                    $arGeneToDisease = new GeneToDisease();
                    $arGeneToDisease->gene_id = $arGene->id;
                    $arGeneToDisease->disease_id = $arDisease->id;
                    $arGeneToDisease->save();
                    $saved++;
                }

            }
            echo $arGene->symbol . ': ' . $saved . ' disease(s) added ' . PHP_EOL;
        }
    }

    /**
     * get-data/get-gene-expression [onlyNew] true [geneNcbiIds] 1,2,3
     * @param string $onlyNew
     * @param null|string $geneNcbiIds
     */
    public function actionGetGeneExpression(string $onlyNew = 'true', string $geneNcbiIds = null)
    {
        $onlyNew = filter_var($onlyNew, FILTER_VALIDATE_BOOLEAN);
        $apiUrl = 'https://www.ncbi.nlm.nih.gov/';
        $arGenesQuery = Gene::find()->where('gene.symbol is not null');
        if($onlyNew) {
            $arGenesQuery->leftJoin('gene_expression_in_sample', 'gene_expression_in_sample.gene_id=gene.id')
                ->andWhere('gene_expression_in_sample.gene_id is null');
        }
        if($geneNcbiIds) {
            $arGenesQuery->andWhere(['in', 'gene.ncbi_id', explode(',', $geneNcbiIds)]);
        }
        $arGenes = $arGenesQuery->all();
        $counter = 1;
        $count = count($arGenes);
        echo $count;
        $client = new Client();
        foreach ($arGenes as $arGene) {
            try {
                echo 'parsing info for gene id=' . $arGene->id . ' ncbi_id=' . $arGene->ncbi_id . ' (' . $counter . ' from ' . $count . ') ... ';
                $url = $apiUrl . 'gene/' . $arGene->ncbi_id . '/expression/details?p$l=Expression';
                $geneInfoPage = $response = $client->createRequest()
                    ->setUrl($url . $arGene->symbol . '?format=json&columns=g,pc')
                    ->setFormat(Client::FORMAT_JSON)
                    ->send();
                if (!$response->isOk) {
                    echo $response->getStatusCode();
                }
                $geneExpression = $this->parseExpressionFromPage($geneInfoPage);
                foreach ($geneExpression as $sample => $expressionValues) {
                    echo $sample . ' ';
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

    /**
     * @param string $geneInfoPage
     * @return array
     * @throws \Exception
     */
    protected function parseExpressionFromPage(string $geneInfoPage): array
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

    public function recursiveCamelCase($items) {
        $newItems = [];
        foreach ($items as $k => $item) {
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