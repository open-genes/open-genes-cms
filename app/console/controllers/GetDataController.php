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
     * todo move logic to service
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function actionGetProteinClasses()
    {
        $apiUrl = 'https://www.proteinatlas.org/search/';
        $arGenes = Gene::find()
            ->all();
        $client = new Client();
        foreach ($arGenes as $arGene) {
            $response = $client->createRequest()
                ->setUrl($apiUrl . $arGene->symbol . '?format=json&columns=g,pc')
                ->setFormat(Client::FORMAT_JSON)
                ->send();
            if (!$response->isOk) {
                echo $response->getStatusCode();
            }
            $parsedResponse = json_decode($response->content, true);

            foreach($parsedResponse as $geneInfo) {
                if ($geneInfo['Gene'] === $arGene->symbol) {
                    echo $arGene->symbol . ': ';
                    foreach ($geneInfo['Protein class'] as $proteinClass) {
                        $nameSearch = [
                            trim($proteinClass),
                            trim(str_replace('proteins', '', $proteinClass)),
                            trim(str_replace('genes', '', $proteinClass))
                        ];
                        $arProteinClass = ProteinClass::find()
                            ->where(['in', 'name_en', $nameSearch])
                            ->one();
                        if(!$arProteinClass) {
                            echo 'NOT FOUND ' . $proteinClass . ' ';
                            continue;
                        }
                        $arGeneToProteinClass = GeneToProteinClass::find()
                            ->where([
                                'protein_class_id' => $arProteinClass->id,
                                'gene_id' => $arGene->id,
                            ])
                            ->one();
                        if(!$arGeneToProteinClass) {
                            $arGeneToProteinClass = new GeneToProteinClass();
                            $arGeneToProteinClass->gene_id = $arGene->id;
                            $arGeneToProteinClass->protein_class_id = $arProteinClass->id;
                            $arGeneToProteinClass->save();
                        }
                        echo '"' . $arProteinClass->name_en . '" ';
                    }
                }
            }
            echo PHP_EOL;
        }
    }


    public function actionGetProteinAtlas($onlyNew = false)
    {
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

    public function actionGetGeneExpression($onlyNew = true)
    {
        $apiUrl = 'https://www.ncbi.nlm.nih.gov/';
        $arGenesQuery = Gene::find();
        if($onlyNew) {
            $arGenesQuery->leftJoin('gene_expression_in_sample', 'gene_expression_in_sample.gene_id=gene.id')
                ->where('gene_expression_in_sample.gene_id is null');
        }
        $arGenes = $arGenesQuery->all();
//        var_dump($arGenes[0]);
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

}