<?php


namespace app\console\service;


use app\models\common\GeneToDisease;
use app\models\Disease;
use app\models\Gene;
use yii\httpclient\Client;

class ParseDiseasesService implements ParseDiseasesServiceInterface
{
    private $apiUrl;

    public function __construct($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    public function parseBiocomp(bool $onlyNew=true, array $geneNcbiIdsArray=[])
    {
        $arGenesQuery = Gene::find()->where('gene.symbol is not null');
        if($onlyNew) {
            $arGenesQuery->leftJoin('gene_to_disease', 'gene_to_disease.gene_id=gene.id')
                ->andWhere('gene_to_disease.gene_id is null');
        }
        if ($geneNcbiIdsArray) {
            $arGenesQuery->andWhere(['in', 'gene.ncbi_id', $geneNcbiIdsArray]);
        }

        $arGenes = $arGenesQuery->all();
        $client = new Client();
        $counter = 1;
        $count = count($arGenes);
        foreach ($arGenes as $arGene) {
            echo "{$arGene->id} {$arGene->ncbi_id} {$arGene->symbol} ({$counter} from {$count}): ";
            try {
                $response = $client->createRequest()
                    ->setUrl($this->apiUrl . $arGene->symbol . '.csv')
                    ->setFormat(Client::FORMAT_JSON)
                    ->send();
                if (!$response->isOk) {
                    throw new \Exception('Failed with status code: ' . $response->getStatusCode());
                }
                if ((int)$response->headers['content-length'] > 10000000) { // todo
                    throw new \Exception('Response is too big: ' . $response->headers['content-length']);
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
                echo $saved . ' disease(s) added ' . PHP_EOL;
            } catch (\Exception $e) {
                echo PHP_EOL . "ERROR {$e->getMessage()} url: {$this->apiUrl}{$arGene->symbol}.csv" . PHP_EOL;
            }
            $counter++;
            echo PHP_EOL;
        }
    }
}