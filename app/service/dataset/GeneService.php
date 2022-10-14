<?php

namespace app\service\dataset;

use app\models\AgeRelatedChange;
use app\models\common\GeneralLifespanExperiment;
use app\models\common\GeneToSource;
use app\models\Gene;
use app\models\GeneInterventionToVitalProcess;
use app\models\GeneToLongevityEffect;
use app\models\repositories\GeneToCommentCauseRepository;
use app\models\Source;

class GeneService
{
    /** @var LifespanExperimentService */
    private $lifespanExperimentService;

    /** @var GeneInterventionToVitalProcessService */
    private $geneInterventionToVitalProcessService;

    /** @var AgeRelatedChangeService */
    private $ageRelatedChangeService;

    /** @var GeneToCommentCauseRepository */
    private $geneToCommentCauseRepository;

    public function __construct(
        LifespanExperimentService $lifespanExperimentService,
        GeneInterventionToVitalProcessService $geneInterventionToVitalProcessService,
        AgeRelatedChangeService $ageRelatedChangeService,
        GeneToCommentCauseRepository $geneToCommentCauseRepository
    ) {
        $this->lifespanExperimentService = $lifespanExperimentService;
        $this->ageRelatedChangeService = $ageRelatedChangeService;
        $this->geneInterventionToVitalProcessService = $geneInterventionToVitalProcessService;
        $this->geneToCommentCauseRepository = $geneToCommentCauseRepository;
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

                    // Purple
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

                    // Green
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

                    // Blue
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
        if ($source = Source::find()->where(['name' => 'GeneAge'])->one()) {
            foreach ($data as $item) {
                $symbol = trim($item[0]);
                if ($gene = Gene::find()->where(['symbol' => $symbol])->one()) {
                    if (GeneToSource::find()->where([
                        'gene_id' => $gene->id,
                        'source_id' => $source->id
                    ])->one()) {
                        echo 'Source with id ' . $source->id  . ' is already set for gene ' . $symbol . PHP_EOL;
                    } else {
                        $geneToSource = new GeneToSource();
                        $geneToSource->gene_id = $gene->id;
                        $geneToSource->source_id = $source->id;
                        try {
                            $geneToSource->save();
                            echo 'Success! Source with id ' . $source->id  . ' is already set for gene ' . $symbol . PHP_EOL;
                        } catch (\Exception $exception) {
                            var_dump($exception->getMessage());
                            continue;
                        }
                    }
                } else {
                    echo "Gene doesn't exist: " . $symbol . PHP_EOL;
                }
            }
        } else {
            echo "Source doesn't exist: " . PHP_EOL;
        }
    }

    public function addCriteriaToGene(array $data) {
        $geneSymbols = [];
        foreach ($data as $item) {
            $symbol = trim($item[0]);
            if ($gene = Gene::find()
                ->where(['symbol' => $symbol])
                ->one()) {
                $gene->isHidden = 0;
                $gene->save();
                if ($item[1] == 'Age-related changes in gene expression/protein activity in humans (blue)') {
                    if (AgeRelatedChange::find()->where([
                        'gene_id' => $gene->id
                    ])->one()) {
                        $this
                            ->geneToCommentCauseRepository
                            ->saveFromCriteria($gene, $item[1]);
                    } else {
                        echo "Gene " . $item[0] . " doesn't have this type of study: blue". PHP_EOL;
                    }
                } elseif ($item[1] == 'Association of genetic variants and gene expression levels with longevity (pink)') {
                    if (GeneToLongevityEffect::find()->where([
                        'gene_id' => $gene->id
                    ])->one()) {
                        $this
                            ->geneToCommentCauseRepository
                            ->saveFromCriteria($gene, $item[1]);
                    } else {
                        echo "Gene " . $item[0] . " doesn't have this type of study: pink". PHP_EOL;
                    }
                }
            } else {
                echo "Gene doesn't exist: " . $symbol . PHP_EOL;
                $geneSymbols[] = $symbol;
            }
        }

        if (!empty($geneSymbols)) {
            $geneSymbols = array_unique($geneSymbols);
            $titleFile = date('Ymd__His') . '_genesNotExist.csv';
            $file = fopen(\Yii::getAlias('@app/') . 'storage/datalogs/' . $titleFile, 'a');
            foreach ($geneSymbols as $symbol) {
                fwrite($file, $symbol . PHP_EOL);
            }
            fclose($file);
            echo 'Log file is ready' . PHP_EOL;
        }
    }

}