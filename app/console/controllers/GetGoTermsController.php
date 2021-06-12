<?php


namespace app\console\controllers;


use app\models\common\Gene;
use app\service\GeneOntologyServiceInterface;
use yii\console\Controller;

class GetGoTermsController extends Controller
{
    public function actionOntologyMineGene($id)
    {
        /** @var GeneOntologyServiceInterface $geneOntologyService */
        $geneOntologyService = \Yii::$container->get(GeneOntologyServiceInterface::class);
        return $geneOntologyService->mineFromGatewayForGene((int) $id);
    }

    /**
     * @param $countGenes integer для какого количества генов собираем записи
     * @param $countRows integer сколько записей запрашивать из GO
     * todo доделать для дозагрузки
     */
    public function actionGetGoTerms($countGenes=null, $countRows=1000)
    {
        /** @var GeneOntologyServiceInterface $geneOntologyService */
        $geneOntologyService = \Yii::$container->get(GeneOntologyServiceInterface::class);
        $ids = Gene::find()
            ->select('ncbi_id')
            ->limit($countGenes)
            ->column();
        foreach ($ids as $id) {
            echo PHP_EOL . $id;
            try {
                $result = $geneOntologyService->mineFromGatewayForGene((int) $id);
                if (isset($result['link_errors'])) {
                    echo ' ERROR ' . $result['link_errors'];
                    continue;
                }
                echo ' ok';
            } catch (\Exception $e) {
                echo ' ERROR ' . $e->getMessage();
            }
        }
        echo PHP_EOL;
    }

    /**
     * Цель алгоритма:   заполнить базу данными атласа (api/gene/ID -> gene.JSON:human_protein_atlas)
     * Источник данных:  https://www.proteinatlas.org/search/<<<SYMBOL>>>?format=json
     *
     * Ресурс работает в 2-х режимах:
     * Обновить всю базу атласа /api/human-protein-mine-gene
     * Скачать данные атласа только для новых генов /api/human-protein-mine-gene?onlyNew=1
     *
     * Ресурс поставляет данные в формате:
     *  info           - массив даннных о процессе обновления атласа. К примеру информация о том, что атлас уже существует (в спец. режиме)
     *  errorsGetENSG  - ошибки поиска гена в атласе
     *  errorsGeneSave - ошибки сохранения модели гена
     *  atlasMapper    - успешно сохраненные данные атласа
     *
     * @param bool $onlyNew
     * @return array
     */
    public function actionHumanProteinMineGene($onlyNew = false)
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

            /*//todo: такая структура была в таске, но потом решили 1 в 1 сохранять. Пока оставляю на всякий случай, но если таск закрыт - можно удалять.
             * $geneAtlasMapper = [
                //"summary" => [
                "tissueSpecificity" => $geneResult['qweqwe'],
                "subcellularLocation" => $geneResult['qweqwe'],
                "cancerPrognosticSummary" => $geneResult['qweqwe'],
                "brainSpecificity" => $geneResult['qweqwe'],
                "bloodSpecificity" => $geneResult['qweqwe'],
                "predictedLocation" => $geneResult['qweqwe'],
                "proteinFunction" => $geneResult['qweqwe'],
                "molecularFunction" => $geneResult['qweqwe'],
                "biologicalProcess" => $geneResult['qweqwe'],
                "diseaseInvolvement" => $geneResult['qweqwe'],
                "ligand" => $geneResult['qweqwe'],
                //],
                //"proteinInformation" => [
                "spliceVariant" => $geneResult['qweqwe'],
                "uniProt" => $geneResult['qweqwe'],
                "proteinClass" => $geneResult['qweqwe'],
                "geneOntology" => $geneResult['qweqwe'],
                "lengthAndMass" => $geneResult['qweqwe'],
                "signalPeptide" => $geneResult['qweqwe'],
                "transmembraneRegions" => $geneResult['qweqwe'],
                //],
                //"geneInformation" => [
                "synonyms" => $geneResult['qweqwe'],
                "chromosome" => $geneResult['qweqwe'],
                "cytoband" => $geneResult['qweqwe'],
                "chromosomeLocation" => $geneResult['qweqwe'],
                "numberOfTranscripts" => $geneResult['qweqwe'],
                "neXtProtId" => $geneResult['qweqwe'],
                "antibodypediaId" => $geneResult['qweqwe'],
                //],
            ];*/

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
    
    /**
     *
     * @param $items
     * @return array
     */
    public function recursiveCamelCase($items) {
        $newItems = [];
        foreach ($items as $k => $item) {
            //todo: это можно сделать одной функцией.
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