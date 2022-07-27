<?php

namespace app\service\dataset;

use app\models\Gene;
use app\models\GeneInterventionToVitalProcess as GeneInterventionToVitalProcessModel;
use app\models\common\GeneInterventionToVitalProcess;

class GeneInterventionToVitalProcessService
{
    public function checkDuplicateAndSave($geneSymbols, GeneInterventionToVitalProcessModel $geneInterventionToVitalProcess) {
        /** @var Gene $geneSymbol */
        foreach ($geneSymbols as $geneSymbol) {
            if (!empty($geneSymbol->geneInterventionToVitalProcesses)) {
                $modelOrganismIds = [];
                foreach ($geneSymbol->geneInterventionToVitalProcesses as $item) {
                    if (!empty($item->model_organism_id)) {
                        $modelOrganismIds[] = $item->model_organism_id;
                    }
                }
                if (!in_array($geneInterventionToVitalProcess->model_organism_id, $modelOrganismIds)) {
                    $this->saveByGene($geneSymbol->id, $geneInterventionToVitalProcess);
                    echo 'saveGreen :' . $geneSymbol->symbol . PHP_EOL;
                }
            } else {
                $this->saveByGene($geneSymbol->id, $geneInterventionToVitalProcess);
                echo 'saveGreen :' . $geneSymbol->symbol . PHP_EOL;
            }
        }
    }

    private function saveByGene(int $geneId, GeneInterventionToVitalProcessModel $geneInterventionToVitalProcess) {
        $item = new GeneInterventionToVitalProcess();
        $item->gene_id = $geneId;
        $item->gene_intervention_id = $geneInterventionToVitalProcess->gene_intervention_id;
        $item->model_organism_id = $geneInterventionToVitalProcess->model_organism_id;
        $item->organism_line_id = $geneInterventionToVitalProcess->organism_line_id;
        $item->age = $geneInterventionToVitalProcess->age;
        $item->sex_of_organism = $geneInterventionToVitalProcess->sex_of_organism;
        $item->reference = $geneInterventionToVitalProcess->reference;
        $item->comment_en = $geneInterventionToVitalProcess->comment_en;
        $item->comment_ru = $geneInterventionToVitalProcess->comment_ru;
        $item->age_unit = $geneInterventionToVitalProcess->age_unit;
        $item->genotype = $geneInterventionToVitalProcess->genotype;
        $item->pmid = $geneInterventionToVitalProcess->pmid;
        $item->gene_intervention_method_id = $geneInterventionToVitalProcess->gene_intervention_method_id;
        $item->save();
    }
}