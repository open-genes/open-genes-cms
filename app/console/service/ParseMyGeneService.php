<?php


namespace app\console\service;


use app\models\Gene;
use yii\db\Exception;
use yii\httpclient\Client;

class ParseMyGeneService implements ParseMyGeneServiceInterface
{
    /** @var string */
    private $apiUrl;
    /** @var Client */
    private $httpClient;

    public function __construct($apiUrl)
    {
        $this->apiUrl = $apiUrl;
        $this->httpClient = new Client();
    }

    public function parseInfo(bool $onlyNew = true, array $geneNcbiIdsArray = [])
    {
        $arGenesQuery = Gene::find()->where('gene.ncbi_id > 0');
        if ($onlyNew) {
            $arGenesQuery->andWhere('gene.summary_en is null or gene.summary_en = "" or gene.summary_en = " "');
        }
        if ($geneNcbiIdsArray) {
            $arGenesQuery->andWhere(['in', 'gene.ncbi_id', $geneNcbiIdsArray]);
        }
        $arGenes = $arGenesQuery->all();
        $counter = 1;
        $count = count($arGenes);
        echo $count;
        foreach ($arGenes as $arGene) {
            try {
                echo "{$arGene->id} {$arGene->ncbi_id} {$arGene->symbol} ({$counter} from {$count}): ";
                $url = $this->apiUrl . 'gene/' . $arGene->ncbi_id . '?fields=symbol%2Cname%2Centrezgene%2Calias%2Csummary';
                $response = $this->httpClient->createRequest()
                    ->setUrl($url)
                    ->send();
                if (!$response->isOk) {
                    echo $response->getStatusCode();
                }
                $parsedResponse = json_decode($response->content, true);
                $arGene->summary_en = $parsedResponse['summary'] ?? '';
                if (!$arGene->symbol) {
                    $arGene->symbol = $parsedResponse['symbol'];
                }
                if (!$arGene->name) {
                    $arGene->name = $parsedResponse['name'];
                }
                if (isset($parsedResponse['alias'])) {
                    $aliases = is_array($parsedResponse['alias']) ? $parsedResponse['alias'] : [$parsedResponse['alias']];
                    array_walk($aliases, function (&$value, &$key) {
                        $value = str_replace(' ', '+', $value);
                    });
                    $arGene->aliases = implode(' ', $aliases);
                }
                $arGene->save();
                echo 'OK' . PHP_EOL;
            } catch (\Exception $e) {
                echo PHP_EOL . 'ERROR ' . $e->getMessage() . ' url: ' . $url . PHP_EOL;
            }
            $counter++;
        }
    }

    /**
     * @param string $symbol
     * @return string
     */
    public function parseBySymbol(string $symbol): Gene
    {
        echo "get {$symbol} from myGene: ";
        $url = $this->apiUrl . 'query?q=' . $symbol . '&fields=symbol%2Cname%2Centrezgene%2Calias%2Csummary&species=human';
        $response = $this->httpClient->createRequest()
            ->setUrl($url)
            ->send();
        if (!$response->isOk) {
            throw new \Exception($response->getStatusCode());
        }
        $parsedResponse = json_decode($response->content, true);
        foreach ($parsedResponse['hits'] as $gene) {
            if ($gene['symbol'] === strtoupper($symbol)) {
                $arGene = new Gene();
                $arGene->symbol = $gene['symbol'];
                $arGene->ncbi_id = $gene['entrezgene'];
                $arGene->name = $gene['name'];
                $arGene->summary_en = $gene['summary'] ?? null;
                if (isset($gene['alias'])) {
                    $aliases = is_array($gene['alias']) ? $gene['alias'] : [$gene['alias']];
                    array_walk($aliases, function (&$value, &$key) {
                        $value = str_replace(' ', '+', $value);
                    });
                    $arGene->aliases = implode(' ', $aliases);
                }
                return $arGene;
            }
        }
        throw new \Exception(' not found ' . $url);
    }
}