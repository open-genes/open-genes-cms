<?php

namespace app\service\dataset;

use app\models\AgeRelatedChange;
use app\models\CommentCause;
use app\models\common\GeneralLifespanExperiment;
use app\models\common\GeneToSource;
use app\models\Gene;
use app\models\GeneInterventionToVitalProcess;
use app\models\GeneToCommentCause;
use app\models\GeneToLongevityEffect;
use app\models\Source;

class GeneService
{
    /** @var LifespanExperimentService */
    private $lifespanExperimentService;

    /** @var GeneInterventionToVitalProcessService */
    private $geneInterventionToVitalProcessService;

    /** @var AgeRelatedChangeService */
    private $ageRelatedChangeService;

    public function __construct(
        LifespanExperimentService $lifespanExperimentService,
        GeneInterventionToVitalProcessService $geneInterventionToVitalProcessService,
        AgeRelatedChangeService $ageRelatedChangeService
    ) {
        $this->lifespanExperimentService = $lifespanExperimentService;
        $this->ageRelatedChangeService = $ageRelatedChangeService;
        $this->geneInterventionToVitalProcessService = $geneInterventionToVitalProcessService;
    }


    public function copyDataToData(array $data) {
        foreach ($data as $item) {
            $symbol = $item[0];
            $symbols = $item[1] ? explode(",", $item[1]) : [];
            $conditions = $item[2] ? explode(",", $item[2]) : [];
            $geneSymbols = [];
            $gene = Gene::find()->where(['symbol' => $symbol])->one();

            if (!empty($gene) && !empty($conditions) && !empty($symbols)) {
                $geneSymbols = Gene::find()->where(['in', 'symbol', $symbols])->all();

                foreach ($conditions as $condition) {

                    // TODO: феолетовый
                    if ($generalLifespanExperiments = GeneralLifespanExperiment::find()
                        ->innerJoin('lifespan_experiment as le', 'general_lifespan_experiment.id=le.general_lifespan_experiment_id')
                        ->innerJoin('model_organism as mo', 'general_lifespan_experiment.model_organism_id=mo.id')
                        ->where([
                            'mo.name_ru' => $condition,
                            'le.gene_id' => $gene->id
                        ])
                        ->all()) {

                        foreach ($generalLifespanExperiments as $generalLifespanExperiment) {
                            /** @var $generalLifespanExperiment GeneralLifespanExperiment */
                            foreach ($generalLifespanExperiment->lifespanExperiments as $lifespanExperiment) {
                                $this
                                    ->lifespanExperimentService
                                    ->checkDuplicateAndSave($geneSymbols, $lifespanExperiment);
                            }
                        }
                    }

                    // TODO: зеленный
                    if ($geneInterventionToVitalProcesses = GeneInterventionToVitalProcess::find()
                        ->innerJoin('model_organism as mo', 'mo.id=gene_intervention_to_vital_process.model_organism_id')
                        ->where([
                            'mo.name_ru' => $condition,
                            'gene_intervention_to_vital_process.gene_id' => $gene->id
                        ])
                        ->all()) {
                        foreach ($geneInterventionToVitalProcesses as $geneInterventionToVitalProcess) {
                            $this
                                ->geneInterventionToVitalProcessService
                                ->checkDuplicateAndSave($geneSymbols, $geneInterventionToVitalProcess);
                        }
                    }

                    // TODO: голубой
                    if ($ageRelatedChanges = AgeRelatedChange::find()
                        ->innerJoin('model_organism as mo', 'mo.id=age_related_change.model_organism_id')
                        ->where([
                            'mo.name_ru' => $condition,
                            'age_related_change.gene_id' => $gene->id
                        ])
                        ->all()) {
                        foreach ($ageRelatedChanges as $ageRelatedChange) {
                            $this
                                ->ageRelatedChangeService
                                ->checkDuplicateAndSave($geneSymbols, $ageRelatedChange);
                        }
                    }
                }
            }
        }

    }

    public function addSourceToGene(array $data) {
        if ($source = Source::find()->where('GeneAge')->one()) {
            foreach ($data as $item) {
                $symbol = trim($item[0]);
                if ($gene = Gene::find()->where(['symbol' => $symbol])->one()) {
                    if (GeneToSource::find()->where([
                        'gene_id' => $gene->id,
                        'source_id' => $source->id
                    ])->one()) {
                        echo 'has: ' . $symbol . PHP_EOL;
                    } else {
                        $geneToSource = new GeneToSource();
                        $geneToSource->gene_id = $gene->id;
                        $geneToSource->source_id = $source->id;
                        try {
                            $geneToSource->save();
                            echo 'success: ' . $symbol . PHP_EOL;
                        } catch (\Exception $exception) {
                            var_dump($exception->getMessage());
                            continue;
                        }
                    }
                } else {
                    echo 'такого гена нет: ' . $symbol . PHP_EOL;
                }
            }
        } else {
            echo 'Источника GeneAge несуществует' . PHP_EOL;
        }
    }

    public function addCriteriaToGene(array $data) {
        $geneSymbols = [];
        foreach ($data as $item) {
            $symbol = trim($item[0]);
            if ($gene = Gene::find()->where(['symbol' => $symbol])->one()) {
                if ($item[1] == 'Age-related changes in gene expression/protein activity in humans') {
                    if (!AgeRelatedChange::find()->where([
                        'gene_id' => $gene->id
                    ])->one()) {
                        echo $item[0] . ' hasn`t Age-Related-Changes experiment'. PHP_EOL;
                    }
                }

                if ($item[1] == 'Association of genetic variants and gene expression levels with longevity') {
                    if (!GeneToLongevityEffect::find()->where([
                        'gene_id' => $gene->id
                    ])->one()) {
                        echo $item[0] . ' hasn`t Gene-To-Longevity-Effect experiment'. PHP_EOL;
                    }
                }

                if ($commentCause = CommentCause::find()->where(['name_en' => $item[1]])->one()) {
                    if (GeneToCommentCause::find()
                        ->where([
                            'gene_id' => $gene->id,
                            'comment_cause_id' => $commentCause->id
                        ])
                        ->one()) {
                        $gene->isHidden = 0;
                        $gene->save();
                    } else {
                        $geneToCommentCause = new GeneToCommentCause();
                        $geneToCommentCause->gene_id = $gene->id;
                        $geneToCommentCause->comment_cause_id = $commentCause->id;
                        $geneToCommentCause->save();
                    }
                }
            } else {
                echo 'Gene is not exist: ' . $symbol . PHP_EOL;
                $geneSymbols[] = $symbol;
            }
        }

        if (!empty($geneSymbols)) {
            $geneSymbols = array_unique($geneSymbols);
            $titleFile = date('Ymd__His') . 'c.csv';
            $file = fopen(\Yii::getAlias('@app/') . 'storage/datalogs/' . $titleFile, 'a');
            foreach ($geneSymbols as $symbol) {
                fwrite($file, $symbol . PHP_EOL);
            }
            fclose($file);
            echo 'Log file is ready' . PHP_EOL;
        }
    }

}
