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
            $arGenesQuery->andWhere(
                'gene.ncbi_summary_en is null or gene.ncbi_summary_en = "" or gene.ncbi_summary_en = " "'
            );
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
                if (strtoupper($arGene->symbol) !== $arGene->symbol) {
                    echo 'not human gene ' . $arGene->symbol . PHP_EOL;
                    continue;
                }
                echo "{$arGene->id} {$arGene->ncbi_id} {$arGene->symbol} ({$counter} from {$count}): ";
                $url = $this->apiUrl . 'gene/' . $arGene->ncbi_id . '?fields=symbol%2Cname%2Centrezgene%2Calias%2Csummary';
                $response = $this->httpClient->createRequest()
                    ->setUrl($url)
                    ->send();
                if (!$response->isOk) {
                    echo $response->getStatusCode();
                }
                $parsedResponse = json_decode($response->content, true);
                $arGene->ncbi_summary_en = $parsedResponse['summary'] ?? '';
                if (!$arGene->symbol) {
                    $arGene->symbol = $parsedResponse['symbol'];
                }
                if (!$arGene->name) {
                    $arGene->name = $parsedResponse['name'];
                }
                if (isset($parsedResponse['alias'])) {
                    $aliases = is_array(
                        $parsedResponse['alias']
                    ) ? $parsedResponse['alias'] : [$parsedResponse['alias']];
                    array_walk($aliases, function (&$value, &$key) {
                        $value = str_replace(' ', '+', $value);
                    });
                    $arGene->aliases = implode(' ', $aliases);
                }
                $arGene->save();
                if (!isset($parsedResponse['summary'])) {
                    echo 'no summary! ';
                }
                echo 'OK' . PHP_EOL;
            } catch (\Exception $e) {
                echo PHP_EOL . 'ERROR ' . $e->getMessage() . ' url: ' . $url . PHP_EOL;
            }
            $counter++;
        }
    }

    /**
     * @param string $symbol
     * @return string|Gene
     */
    public function parseBySymbol(string $symbol)
    {
        echo "get {$symbol} from myGene: ";
        $url = $this->apiUrl . 'query?q=' . $symbol . '&fields=symbol%2Cname%2Centrezgene%2Calias%2Csummary&species=human';
        $response = $this->httpClient->createRequest()
            ->setUrl($url)
            ->send();
        try {
            $parsedResponse = json_decode($response->content, true);
            if (!empty($parsedResponse['hits'])) {
                foreach ($parsedResponse['hits'] as $gene) {
                    $aliases = $this->getAliases($gene);
                    if (in_array(strtoupper($symbol), $aliases)) {
                        $arGene = new Gene();
                        $arGene->symbol = $gene['symbol'];
                        $arGene->ncbi_id = $gene['entrezgene'];
                        $arGene->name = $gene['name'];
                        $arGene->ncbi_summary_en = $gene['summary'] ?? null;
                        if (isset($gene['alias'])) {
                            $aliases = is_array($gene['alias']) ? $gene['alias'] : [$gene['alias']];
                            array_walk($aliases, function (&$value, &$key) {
                                $value = str_replace(' ', '+', $value);
                            });
                            $arGene->aliases = implode(' ', $aliases);
                        }
                        if (!isset($gene['summary'])) {
                            echo ' no summary! ';
                        }
                        return $arGene;
                    }
                }
            }
        } catch (\Exception $e) {
            echo $e . ' not found ' . $url . ' ' . $response->getStatusCode();
        }
    }

    private function getAliases(array $geneData): array
    {
        $result = [$geneData['symbol']];
        if (!isset($geneData['alias'])) {
            return $result;
        }
        if (is_string($geneData['alias'])) {
            $result[] = $geneData['alias'];
            return $result;
        }
        foreach ($geneData['alias'] as $alias) {
            $result[] = $alias;
        }
        return $result;
    }
}