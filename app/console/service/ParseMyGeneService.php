<?php


namespace app\console\service;


use app\models\Gene;
use yii\httpclient\Client;

class ParseMyGeneService implements ParseMyGeneServiceInterface
{
    private $apiUrl;

    public function __construct($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    public function parseInfo(bool $onlyNew=true, array $geneNcbiIdsArray=[])
    {
        $arGenesQuery = Gene::find()->where('gene.ncbi_id > 0');
        if($onlyNew) {
            $arGenesQuery->andWhere('gene.summary_en is null');
        }
        if($geneNcbiIdsArray) {
            $arGenesQuery->andWhere(['in', 'gene.ncbi_id', $geneNcbiIdsArray]);
        }
        $arGenes = $arGenesQuery->all();
        $counter = 1;
        $count = count($arGenes);
        echo $count;
        $client = new Client();
        foreach ($arGenes as $arGene) {
            try {
                echo "{$arGene->id} {$arGene->ncbi_id} {$arGene->symbol} ({$counter} from {$count}): ";
                $response = $client->createRequest()
                    ->setUrl($this->apiUrl  . $arGene->ncbi_id . '?fields=summary,symbol')
                    ->send();
                if (!$response->isOk) {
                    echo $response->getStatusCode();
                }
                $parsedResponse = json_decode($response->content, true);
                $arGene->summary_en = $parsedResponse['summary'];
                if (!$arGene->symbol) {
                    $arGene->symbol = $parsedResponse['symbol'];
                }
                $arGene->save();
                echo 'OK' . PHP_EOL;
            } catch (\Exception $e) {
                echo PHP_EOL . 'ERROR ' . $e->getMessage() . ' url: ' . $this->apiUrl  . $arGene->ncbi_id . '?fields=summary' . PHP_EOL;
            }
            $counter++;
        }
    }
}