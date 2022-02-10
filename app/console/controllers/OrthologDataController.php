<?php

namespace app\console\controllers;

use app\models\Gene;
use app\models\GeneToOrtholog;
use app\models\ModelOrganism;
use app\models\Ortholog;
use app\models\Source;
use Yii;
use yii\helpers\Console;

class OrthologDataController extends MigrateDataController
{
    public function behaviors()
    {
        return parent::behaviors();
    }

    public function actionOrthologToLifespan()
    {
        $sql = 'UPDATE lifespan_experiment le
                JOIN gene_to_orthologs gto ON le.gene_id = gto.gene_id
                JOIN orthologs o ON gto.ortholog_id = o.id
                SET le.ortholog_id = o.id
                WHERE le.model_organism_id = o.model_organism_id';
        Yii::$app->db->createCommand($sql)->execute();
    }

    public function actionHumanGeneFromGeneageFlies($geneAgeData, $fybaseData) {
        if (!file_exists($geneAgeData)) {
            return 'Cannot find geneage data file';
        }
        if (!file_exists($fybaseData)) {
            return 'Cannot find flybase data file';
        }
        $flybaseSymbols = $this->getFlybaseSymbols($geneAgeData);
        if(!is_array($flybaseSymbols)) {
            return $flybaseSymbols;
        }
        $this->saveGeneByFlyOrthologs($fybaseData, $flybaseSymbols);
    }

    public function actionHumanGeneFromGeneageMice($geneAgeData) {
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
            return 'Mice ortholog was retrieved';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function actionImportOrthologsFromFlybase($absolutePathToFile)
    {
        if (!file_exists($absolutePathToFile)) {
            return 'Cannot find data file';
        }
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
                exec("php {$consoleDir}/yii.php migrate-data/import-orthologs-from-flybase-inner {$params}");
            }
            return 'New orthologs successfully added';
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    public function actionImportOrthologsFromFlybaseInner($params)
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
        }
        else {
            $orthologId = $ortholog->id;
        }
        if ($this->existRelationToGene($orthologId, $geneId)) {
            return;
        }
        $this->createRelationToGene($geneId, $orthologId);
    }

    private function getHumanSymbol(string $mouseSymbol): array {
        switch ($mouseSymbol) {
            case 'Trp53bp1':
                return ['TP53BP1'];
            case 'Trp53':
                return ['TP53'];
            case 'Siglece':
                return  ['SIGLEC12', 'SIGLEC8', 'SIGLEC9', 'SIGLEC7'];
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

    private function saveOrtholog(string $symbol, int $modelOrganismId): int {
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

    private function saveGeneByOrtholog(string $humanSymbol, int $orthologId) {
        $humanGeneId = $this->saveGene($humanSymbol, Source::GENEAGE);
        if ($humanGeneId == null) {
            Console::output('Relation for ortholog ' . $orthologId . ' was not added! Please, do it by hand');
            return;
        }
        if ($this->existRelationToGene($orthologId, $humanGeneId)) {
            return;
        }
        $this->createRelationToGene($humanGeneId, $orthologId);
    }

    private function createNewOrthologFly(array $data, int $flyId): int {
        $ortholog = new Ortholog();
        $ortholog->symbol = $data[1];
        $ortholog->model_organism_id = $flyId;
        $ortholog->external_base_id = $data[0];
        $ortholog->external_base_name = 'flybase';
        if($ortholog->save()) {
            Yii::info('New ortholog ' . $ortholog->id . ' successfully created');
        }
        return $ortholog->id;
    }

    private function existRelationToGene($currentOrthologId, $currentGeneId): bool {
        $geneToOrtholog = GeneToOrtholog::find()
            ->where(['gene_id' => $currentGeneId])
            ->andWhere(['ortholog_id' => $currentOrthologId])
            ->one();
        if ($geneToOrtholog) {
            return true;
        }
        return false;
    }

    private function createRelationToGene(int $geneId, int $orthologId) {
        $geneToOrtholog = new GeneToOrtholog();
        $geneToOrtholog->gene_id = $geneId;
        $geneToOrtholog->ortholog_id = $orthologId;
        if($geneToOrtholog->save()) {
            Yii::info('New relations for ortholog => gene ' . $geneToOrtholog->ortholog_id . ' => ' . $geneToOrtholog->gene_id . ' successfully created');
        }
    }

    private function getFlybaseSymbols($geneAgeData) {
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

    private function saveGeneByFlyOrthologs($fybaseData, $flybaseSymbols) {
        $f = fopen($fybaseData, 'r');
        $count = 0;
        try {
            while (($data = fgetcsv($f, 0, "\t")) !== false) {
                $count++;
                Console::output('Flybase table rows processed: ' . $count);
                $flybaseSymbol = $data[1];
                if(!in_array($flybaseSymbol, $flybaseSymbols)) {
                    continue;
                }
                $this->saveGene($data[4], Source::GENEAGE);
            }
            Console::output('New genes successfully added');
            return 0;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}