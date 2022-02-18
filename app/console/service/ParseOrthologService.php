<?php

namespace app\console\service;

use app\models\Gene;
use app\models\GeneToOrtholog;
use app\models\ModelOrganism;
use app\models\Ortholog;
use app\models\Source;
use Yii;
use yii\helpers\Console;

class ParseOrthologService implements ParseOrthologServiceInterface
{
    public function parseHumanGeneFromGeneageFlies(string $geneAgeData, string $fybaseData)
    {
        $flybaseSymbols = $this->parseFlybaseSymbols($geneAgeData);
        if (!is_array($flybaseSymbols)) {
            return $flybaseSymbols;
        }
        return $this->parseGeneByFlyOrthologs($fybaseData, $flybaseSymbols);
    }

    public function parseHumanGeneFromGeneageMice(string $geneAgeData)
    {
        $modelOrganism = ModelOrganism::find()->where(['name_lat' => 'Mus musculus'])->one();
        $f = fopen($geneAgeData, 'r');
        $count = 0;
        try {
            while (($data = fgetcsv($f, 0)) !== false) {
                $count++;
                Console::output('Geneage table rows processed: ' . $count);
                if ($data[3] != 'Mus musculus') {
                    continue;
                }
                $mouseSymbol = $data[1];
                $orthologId = $this->saveOrtholog($mouseSymbol, $modelOrganism->id);
                $humanSymbol = $this->getHumanSymbol($mouseSymbol);
                foreach ($humanSymbol as $symbol) {
                    $this->saveGeneByOrtholog($symbol, $orthologId);
                }
            }
            Console::output('Mice orthologs was retrieved');
            return 0;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function parseOrthologsFromFlybase(string $absolutePathToFile)
    {
        $consoleDir = \Yii::getAlias('@app/console');
        $f = fopen($absolutePathToFile, 'r');
        $fly = ModelOrganism::find()->where(['name_lat' => 'Drosophila melanogaster'])->one();

        $genes = Gene::find()->select(['id', 'symbol'])
            ->where(['not', ['symbol' => null]])
            ->andWhere(['not', ['symbol' => '']])
            ->asArray()->all();
        $geneSymbolToId = [];
        foreach ($genes as $gene) {
            $geneSymbolToId[$gene['symbol']] = $gene['id'];
        }

        $count = 0;
        try {
            while (($data = fgetcsv($f, 0, "\t")) !== false) {
                $count++;
                Console::output('Table rows processed: ' . $count);
                if (!isset($geneSymbolToId[$data[4]])) {
                    continue;
                }
                $geneId = $geneSymbolToId[$data[4]];
                $params = escapeshellarg(serialize([$geneId, $data, $fly->id]));
                exec("php {$consoleDir}/yii.php ortholog-data/import-orthologs-from-flybase-inner {$params}");
            }
            return 'New orthologs successfully added';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function parseOrthologsFromFlybaseInner(string $params)
    {
        $params = unserialize($params);
        list($geneId, $data, $flyId) = $params;
        $ortholog = Ortholog::find()
            ->select(['id'])
            ->where(['model_organism_id' => $flyId])
            ->andWhere(['symbol' => $data[1]])
            ->one();

        if ($ortholog == null) {
            $orthologId = $this->createNewOrthologFly($data, $flyId);
        } else {
            $orthologId = $ortholog->id;
        }
        if ($this->existRelationToGene($orthologId, $geneId)) {
            return;
        }
        $this->createRelationToGene($geneId, $orthologId);
    }

    private function parseGeneByFlyOrthologs(string $flybaseData, array $flybaseSymbols)
    {
        $f = fopen($flybaseData, 'r');
        $count = 0;
        try {
            while (($data = fgetcsv($f, 0, "\t")) !== false) {
                $count++;
                Console::output('Flybase table rows processed: ' . $count);
                $flybaseSymbol = $data[1];
                if (!in_array($flybaseSymbol, $flybaseSymbols)) {
                    continue;
                }
                GeneHelper::saveGeneBySymbol($data[4], Source::GENEAGE);
            }
            Console::output('New genes successfully added');
            return 0;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    private function parseFlybaseSymbols(string $geneAgeData)
    {
        $f = fopen($geneAgeData, 'r');
        $count = 0;
        $flybaseSymbols = [];
        try {
            while (($data = fgetcsv($f, 0)) !== false) {
                $count++;
                Console::output('Geneage table rows processed: ' . $count);
                if ($data[3] != 'Drosophila melanogaster') {
                    continue;
                }
                $flybaseSymbols[] = $data[1];
            }
            Console::output('Flybase symbols was retrieved');
            return $flybaseSymbols;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    private function getHumanSymbol(string $mouseSymbol): array
    {
        switch ($mouseSymbol) {
            case 'Trp53bp1':
                return ['TP53BP1'];
            case 'Trp53':
                return ['TP53'];
            case 'Siglece':
                return ['SIGLEC12', 'SIGLEC8', 'SIGLEC9', 'SIGLEC7'];
            case 'Trp63':
                return ['TP63'];
            case 'Txn1':
                return ['TXN'];
            case 'Agtr1a':
                return ['AGTR1'];
            case 'Trp73':
                return ['TP73'];
            default:
                return [strtoupper(trim($mouseSymbol))];
        }
    }

    private function saveOrtholog(string $symbol, int $modelOrganismId): int
    {
        $ortholog = Ortholog::find()->where(['symbol' => $symbol, 'model_organism_id' => $modelOrganismId])->one();
        if ($ortholog) {
            echo 'ortholog found' . PHP_EOL;
        } else {
            $ortholog = new Ortholog();
            $ortholog->symbol = $symbol;
            $ortholog->model_organism_id = $modelOrganismId;
            $ortholog->save();
            echo 'OK ' . $symbol . PHP_EOL;
        }
        return $ortholog->id;
    }

    private function saveGeneByOrtholog(string $humanSymbol, int $orthologId)
    {
        $humanGeneId = GeneHelper::saveGeneBySymbol($humanSymbol, Source::GENEAGE);
        if ($humanGeneId == null) {
            Console::output('Relation for ortholog ' . $orthologId . ' was not added! Please, do it by hand');
            return;
        }
        if ($this->existRelationToGene($orthologId, $humanGeneId)) {
            return;
        }
        $this->createRelationToGene($humanGeneId, $orthologId);
    }

    private function createNewOrthologFly(array $data, int $flyId): int
    {
        $ortholog = new Ortholog();
        $ortholog->symbol = $data[1];
        $ortholog->model_organism_id = $flyId;
        $ortholog->external_base_id = $data[0];
        $ortholog->external_base_name = 'flybase';
        if ($ortholog->save()) {
            Yii::info('New ortholog ' . $ortholog->id . ' successfully created');
        }
        return $ortholog->id;
    }

    private function existRelationToGene(int $currentOrthologId, int $currentGeneId): bool
    {
        $geneToOrtholog = GeneToOrtholog::find()
            ->where(['gene_id' => $currentGeneId])
            ->andWhere(['ortholog_id' => $currentOrthologId])
            ->one();
        if ($geneToOrtholog) {
            return true;
        }
        return false;
    }

    private function createRelationToGene(int $geneId, int $orthologId)
    {
        $geneToOrtholog = new GeneToOrtholog();
        $geneToOrtholog->gene_id = $geneId;
        $geneToOrtholog->ortholog_id = $orthologId;
        if ($geneToOrtholog->save()) {
            Yii::info(
                'New relations for ortholog => gene ' . $geneToOrtholog->ortholog_id . ' => ' . $geneToOrtholog->gene_id . ' successfully created'
            );
        }
    }
}