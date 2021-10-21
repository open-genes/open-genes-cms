<?php
namespace app\service;

use app\infrastructure\CrossService;
use app\models\common\Gene;
use app\models\common\GeneOntology;
use app\models\common\GeneToOntology;
use Exception;
use Yii;

/**
 * ---===PROTOTYPE===---
 * Парсинг
 * Всех генов
     /api/ontology-mine
 * Конкретного гена
     /api/ontology-mine-gene?id=2
 *
 * По всем генам
     /api/ontology
 * По конкретному гену
     /api/ontology-gene?id=2
 *
 * Class GeneOntologyService
 * @package genes\application\service
 */
class GeneOntologyService implements GeneOntologyServiceInterface
{

    /**
     * @param $geneNcbiId int
     * @param $rows int
     * @return array (errors, gene_ontology, gene_entrez
     * @throws Exception
     */
    public function mineFromGatewayForGene($geneNcbiId, $rows = 2000)
    {
        $result = [];
        $geneRecord = Gene::find()
            ->where(['ncbi_id' => $geneNcbiId])
            ->one();

        if (!$geneRecord) {
            throw new Exception('Gene not found ' . $geneNcbiId);
        }

        $result['entrez_gene'] = $geneRecord->ncbi_id;

        //todo: добавить это в params.php
        // todo что это вообще такое и зачем оно нужно? спросить Олега
        Yii::$app->params['servicesPath']['geneontology'] = 'http://api.geneontology.org';
        $geneOntologyGateway = CrossService::requestGetGateway('geneontology',
            "api/bioentity/gene/{$geneRecord->ncbi_id}/function?rows={$rows}&facet=false&unselect_evidence=false&exclude_automatic_assertions=false&fetch_objects=false&use_compact_associations=false", []);

        $geneOntologyGateway->unsetJson();
        $geneOntologyGateway->unsetInnerRequest();

        $genesJson = $geneOntologyGateway->request();

        if ($geneOntologyGateway->status == 301) {
            $result['errors'] = '301 for ncbi_id :' . $geneRecord->ncbi_id;
            return $result;
        }

        if ($geneOntologyGateway->status == 404) {
            $result['errors'] = '404 for ncbi_id :' . $geneRecord->ncbi_id;
            return $result;
        }

        $genes = (array)json_decode($genesJson, true);

        /*
        Получаем список генов, по которым производим парсинг
        http://api.geneontology.org/api/bioentity/gene/2/function?rows=1000000&facet=false&unselect_evidence=false&exclude_automatic_assertions=false&fetch_objects=false&use_compact_associations=false
        Фильтруем по taxon.label: "Homo sapiens" - не хомо удаляем
        molecular_activity - пока считаем, что это функция
        получаем список функций, процессов и компонентов
        */

        if (!isset($genes['associations'])) {
            throw new \Exception('No associations for gene ');
        }
        foreach ($genes['associations'] as $gene) {

            if ($gene['subject']['taxon']['label'] != 'Homo sapiens') {
                throw new \Exception('No Homo sapiens' . json_encode($gene));
            }
            
            if (!empty($gene['object']['id'])) {
                $go = $gene['object']['id'];
                if (!($go)) {
                    throw new Exception('GO id is out of format: ' . $gene['object']['id']);
                }
            }

            $geneOntology = GeneOntology::find()
                ->where(['ontology_identifier' => $go])->one();
            
            if(!$geneOntology) {
                $geneOntology = new GeneOntology();

                $geneOntology->ontology_identifier = $go;
                if (!empty($gene['object']['category'])) {
                    //CATEGORIES  //biological_process //cellular_component //molecular_activity
                    $geneOntology->category = $gene['object']['category'][0];
                }

                if (!empty($gene['object']['label'])) {
                    $geneOntology->name_en = $gene['object']['label'];
                }

                if (!$geneOntology->save()) {
                    $result['errors'] = $geneOntology->getErrors();
                }
                $result['gene_ontology'] = $geneOntology->attributes;
            }
            
            $gto = GeneToOntology::find()->where([
                'gene_id' => $geneRecord->id,
                'gene_ontology_id' => $geneOntology->id,
            ])->one();

            if (!$gto) {
                $gto = new GeneToOntology();
                $gto->gene_id = $geneRecord->id;
                $gto->gene_ontology_id = $geneOntology->id;
            }

            if (!$gto->save()) {
                $result['link_errors'] = $gto->getErrors();
            }
        }
        
        return $result;
    }

    /**
     * @return array|GeneOntology[]
     */
    public function getAllWithGenes()
    {
        return GeneOntology::find()->all();
    }

    /**
     * @param $gene
     * @return array|Gene[]
     * @throws Exception
     */
    public function getForGene($gene)
    {
        $gene = Gene::find()
            ->where(['ncbi_id' => $gene])
            ->one();

        if (!$gene) {
            throw new Exception('Enter valid gene.ncbi_id');
        }

        return Gene::find()
            ->where(['gene_id' => $gene->id])

            ->addSelect('gene.*')

            ->addSelect('gene_to_ontology.*')
            ->join(
                'LEFT JOIN',
                'gene_to_ontology',
                'gene.id = gene_to_ontology.gene_id'
            )

            ->addSelect('gene_ontology.*')
            ->join(
                'LEFT JOIN',
                'gene_ontology',
                'gene_ontology.id = gene_to_ontology.gene_ontology_id'
            )

            ->asArray()
            ->all();
    }

    /**
     * @param $geneId
     * @return array
     * @throws Exception
     */
    public function getFunctionsForGene($geneId)
    {
        $gene = Gene::find()
            ->where(['ncbi_id' => $geneId])
            ->one();

        if (!$gene) {
            throw new Exception('Enter valid gene.ncbi_id');
        }

        $terms = GeneToOntology::find()
            ->where(['gene_id' => $gene->id])
            ->addSelect('
                ontology_identifier,
                gene_ontology.name_en,
                gene_ontology.name_ru,
                gene_ontology.category
                ')
            ->join(
                'JOIN',
                'gene_ontology',
                'gene_ontology.id = gene_to_ontology.gene_ontology_id'
            )
            ->asArray()
            ->all();

        return $this->termMap($terms);
    }

    public function termMap($terms)
    {
        $categories = [
            'biological_process' => [],
            'cellular_component' => [],
            'molecular_activity' => [],
        ];

        foreach ($terms as $term) {
            $categories[$term['category']][] = [
                $term['ontology_identifier'] => $term['name_en']
            ];
        }

        return $categories;
    }
}