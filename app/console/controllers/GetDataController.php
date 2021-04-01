<?php


namespace app\console\controllers;


use app\models\common\GeneToDisease;
use app\models\common\GeneToProteinClass;
use app\models\Disease;
use app\models\Gene;
use app\models\ProteinClass;
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
            ->where(['isHidden' => 0])
            ->andWhere('commentEvolution != ""')
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
    
    public function actionGetDiseasesFromBiocomp()
    {
//        $test = 'PS10101';
//        var_dump((int)$test);
//        var_dump(filter_var($test, FILTER_SANITIZE_NUMBER_INT));
//        die;
        
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
}