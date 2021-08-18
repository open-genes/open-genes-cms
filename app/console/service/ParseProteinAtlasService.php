<?php


namespace app\console\service;


use app\models\common\GeneToProteinClass;
use app\models\Gene;
use app\models\ProteinClass;
use yii\httpclient\Client;

class ParseProteinAtlasService implements ParseProteinAtlasServiceInterface
{
    private $apiUrl;

    public function __construct($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    public function parseFullAtlas(bool $onlyNew=true, array $geneNcbiIdsArray=[], string $geneSearchName='')
    {
        $arGenesQuery = Gene::find()->where('gene.symbol is not null');
        if ($onlyNew) {
            $arGenesQuery->andWhere('gene.human_protein_atlas is null or gene.human_protein_atlas = "" or gene.human_protein_atlas = " "');
        }
        if($geneNcbiIdsArray) {
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
            if (strtoupper($arGene->symbol)  !== $arGene->symbol) {
                echo 'not human gene ' . $arGene->symbol . PHP_EOL;
                continue;
            }
            echo "{$arGene->id} {$arGene->ncbi_id} {$arGene->symbol} ({$counter} from {$count}): ";
            $searchGene = !empty($geneSearchName) ? $geneSearchName : urlencode("{$arGene->ncbi_id} {$arGene->symbol}");
            try {
                $url = "{$this->apiUrl}{$searchGene}?format=json";
                $response = $client->createRequest()
                    ->setUrl($url)
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
                echo PHP_EOL . "ERROR {$e->getMessage()} url: {$url}" . PHP_EOL;
            }
            $counter++;
            echo PHP_EOL;
        }
    }

    public function parseClasses(bool $onlyNew=true, array $geneNcbiIdsArray=[], string $geneSearchName='')
    {
        $arGenesQuery = Gene::find()->where('gene.symbol is not null');
        if($onlyNew) {
            $arGenesQuery->leftJoin('gene_to_protein_class', 'gene_to_protein_class.gene_id=gene.id')
                ->andWhere('gene_to_protein_class.gene_id is null');
        }
        if($geneNcbiIdsArray) {
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
            if (strtoupper($arGene->symbol)  !== $arGene->symbol) {
                echo 'not human gene ' . $arGene->symbol . PHP_EOL;
                continue;
            }
            echo "{$arGene->id} {$arGene->ncbi_id} {$arGene->symbol} ({$counter} from {$count}): ";
            $searchGene = !empty($geneSearchName) ? $geneSearchName : urlencode("{$arGene->ncbi_id} {$arGene->symbol}");
            try {
                $url = "{$this->apiUrl}{$searchGene}?format=json&columns=g,pc";
                $response = $client->createRequest()
                    ->setUrl($url)
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
                echo PHP_EOL . "ERROR {$e->getMessage()} url: {$url}" . PHP_EOL;
            }
            $counter++;
            echo PHP_EOL;
        }
    }

    private function recursiveCamelCase($items) {
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