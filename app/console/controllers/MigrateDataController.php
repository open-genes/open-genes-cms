<?php

namespace app\console\controllers;

use app\console\service\GeneHelper;
use app\console\service\ParseMyGeneServiceInterface;
use app\models\CommentCause;
use app\models\common\GeneToSource;
use app\models\Disease;
use app\models\GeneInterventionResultToVitalProcess;
use app\models\GeneInterventionToVitalProcess;
use app\models\GeneralLifespanExperiment;
use app\models\GeneralLifespanExperimentToVitalProcess;
use app\models\GeneToOrtholog;
use app\models\LifespanExperiment;
use app\models\ModelOrganism;
use app\models\Ortholog;
use app\models\Phylum;
use app\models\FunctionalCluster;
use app\models\Gene;
use app\models\common\GeneExpressionInSample;
use app\models\GeneToCommentCause;
use app\models\GeneToFunctionalCluster;
use app\models\Sample;
use app\models\Source;
use Yii;
use yii\console\Controller;
use yii\db\ActiveQuery;
use yii\db\Query;
use yii\helpers\Console;
use yii\helpers\VarDumper;

class MigrateDataController extends Controller
{
    public function behaviors()
    {
        return parent::behaviors();
    }

    public function actionMigrateExpression()
    {
        $samplesNames = [];
        $arGenes = Gene::find()->all();
        foreach ($arGenes as $arGene) {
            echo $arGene->symbol . ': ';
            $expression = json_decode($arGene->expressionEN, true);
            $expressionRu = json_decode($arGene->expression, true);
            if ($expression) {
                $geneSamplesNamesEn = array_keys($expression);
                $geneSamplesNamesRu = array_keys($expressionRu);
                $samplesNames = array_merge($samplesNames, array_combine($geneSamplesNamesEn, $geneSamplesNamesRu));
                foreach ($expression as $sample => $expressionValues) {
                    echo $sample . ' ';
                    $arSample = Sample::find()
                        ->andWhere(['name_en' => $sample])
                        ->one();
                    if (!$arSample) {
                        $arSample = new Sample();
                        $arSample->name_en = $sample;
                        $arSample->name_ru = $samplesNames[$sample];
                        $arSample->save();
                        $arSample->refresh();
                    }
                    $arGeneExpressionSample = GeneExpressionInSample::find()
                        ->andWhere(['gene_id' => $arGene->id])
                        ->andWhere(['sample_id' => $arSample->id])
                        ->one();
                    if (!$arGeneExpressionSample) {
                        $arGeneExpressionSample = new GeneExpressionInSample();
                        $arGeneExpressionSample->gene_id = $arGene->id;
                        $arGeneExpressionSample->sample_id = $arSample->id;
                    }
                    $arGeneExpressionSample->expression_value = $expressionValues['full_rpkm'];
                    $arGeneExpressionSample->save();
                }
            } else {
                echo 'No expression for gene ' . $arGene->id;
            }
            echo PHP_EOL;
        }
    }

    public function actionMigrateFunctionalClusters()
    {
        $arGenes = Gene::find()->all();
        foreach ($arGenes as $arGene) {
            echo $arGene->symbol . ': ';
            $functionalClustersRu = explode(',', $arGene->functionalClusters);
            if ($functionalClustersRu) {
                foreach ($functionalClustersRu as $functionalClusterRu) {
                    $functionalClusterRu = trim($functionalClusterRu);
                    $arFunctionalCluster = FunctionalCluster::find()
                        ->where(['name_ru' => $functionalClusterRu])
                        ->one();
                    if (!$arFunctionalCluster) {
                        $arFunctionalCluster = new FunctionalCluster();
                        $arFunctionalCluster->name_ru = $functionalClusterRu;
                        $arFunctionalCluster->name_en = \Yii::t(
                            'main',
                            str_replace([' ', '/'], '_', $functionalClusterRu),
                            [],
                            'en-US'
                        );
                        $arFunctionalCluster->save();
                        $arFunctionalCluster->refresh();
                    }
                    $arGeneToFunctionalCluster = GeneToFunctionalCluster::find()
                        ->andWhere(['gene_id' => $arGene->id])
                        ->andWhere(['functional_cluster_id' => $arFunctionalCluster->id])
                        ->one();
                    if (!$arGeneToFunctionalCluster) {
                        $arGeneToFunctionalCluster = new GeneToFunctionalCluster();
                        $arGeneToFunctionalCluster->gene_id = $arGene->id;
                        $arGeneToFunctionalCluster->functional_cluster_id = $arFunctionalCluster->id;
                    }
                    $arGeneToFunctionalCluster->save();
                    echo $arFunctionalCluster->name_ru . ' ';
                }
                echo PHP_EOL;
            }
        }
    }

    public function actionMigrateAge()
    {
        $arGenes = Gene::find()->all();
        foreach ($arGenes as $arGene) {
            echo $arGene->symbol . ': ';
            if ($arGene->agePhylo) {
                if ($arGene->agePhylo == 'Procaryota') {
                    $arGene->agePhylo = 'Prokaryota';
                }
                $arAge = Phylum::find()->where(
                    ['name_phylo' => $arGene->agePhylo]
                )->one();
            } elseif ($arGene->ageMya) {
                $arAge = $arAge = Phylum::find()->where(
                    ['name_mya' => $arGene->ageMya]
                );
            }
            if (isset($arAge) && $arAge instanceof Phylum) {
                $arGene->age_id = $arAge->id;
                $arGene->save();
                echo $arAge->name_phylo . PHP_EOL;
            } else {
                echo 'no age info' . PHP_EOL;
            }
        }
    }

    public function actionMigrateCommentCause()
    {
        $arGenes = Gene::find()->all();
        foreach ($arGenes as $arGene) {
            echo $arGene->symbol . ': ';
            $commentCausesRu = explode(',', $arGene->commentCause);
            if ($commentCausesRu) {
                foreach ($commentCausesRu as $commentCauseRu) {
                    $commentCauseRu = trim($commentCauseRu);
                    $arCommentCause = CommentCause::find()
                        ->where(['name_ru' => $commentCauseRu])
                        ->one();
                    if (!$arCommentCause) {
                        $arCommentCause = new CommentCause();
                        $arCommentCause->name_ru = $commentCauseRu;
                        $nameForTranslate = str_replace([' ', '/'], '_', mb_strtolower($commentCauseRu));
                        $arCommentCause->name_en = \Yii::t('main', $nameForTranslate, [], 'en-US');
                        $arCommentCause->save();
                        $arCommentCause->refresh();
                    }
                    $arGeneToCommentCause = GeneToCommentCause::find()
                        ->andWhere(['gene_id' => $arGene->id])
                        ->andWhere(['comment_cause_id' => $arCommentCause->id])
                        ->one();
                    if (!$arGeneToCommentCause) {
                        $arGeneToCommentCause = new GeneToCommentCause();
                        $arGeneToCommentCause->gene_id = $arGene->id;
                        $arGeneToCommentCause->comment_cause_id = $arCommentCause->id;
                    }
                    $arGeneToCommentCause->save();
                    echo $arCommentCause->name_ru . ' ';
                }
                echo PHP_EOL;
            }
        }
    }

    public function actionMigrateAbdb($pathToFile = 'abdb.json')
    {
        $json = file_get_contents($pathToFile);
        $array = json_decode($json, true);

        $counter = 1;
        $count = count($array['data']);
        foreach ($array['data'] as $gene) {
            try {
                echo $counter . ' from ' . $count . ': ';
                GeneHelper::saveGeneBySymbol($gene[1], Source::ABDB);
            } catch (\Exception $e) {
                echo 'ERROR ' . $e->getMessage() . PHP_EOL;
            }
            $counter++;
        }
    }

    public function actionSetVisibleIcdCodes($onlyNew = 'true', $icdCategoryDepth = 1)
    {
        $onlyNew = filter_var($onlyNew, FILTER_VALIDATE_BOOLEAN);
        $diseasesQuery = Disease::find()
            ->where('name_en is not null');
        if ($onlyNew) {
            $diseasesQuery->andWhere('icd_code_visible is null or icd_code_visible = ""');
        }
        $diseases = $diseasesQuery->all();

        echo PHP_EOL;
        foreach ($diseases as $disease) {
            echo $disease->icd_code;
            try {
                $visibleCategory = $disease->getIcdCategoryByLevel($icdCategoryDepth);
                if ($visibleCategory) {
                    $disease->icd_code_visible = trim($visibleCategory);
                    if ($disease->save()) {
                        echo ' -> ' . $visibleCategory;
                    } else {
                        echo ' error ' . var_export($disease->errors, true);
                    }
                } else {
                    echo ' error!';
                }
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
            echo PHP_EOL;
        }
    }

    public function actionNewGenesDatasets($pathToFile, $source)
    {
        $pathToFile = \Yii::getAlias('@app/') . $pathToFile;
        if (!file_exists($pathToFile)) {
            return 'Cannot find data file';
        }
        $f = fopen($pathToFile, 'r');
        $dataId = $source == 'longevity-association' || $source == 'human-change-expression'
            ? 1 : 0;
        $geneDataset = [];
        while (($data = fgetcsv($f, 0, ',')) !== false) {
            $geneDataset[] = $data[$dataId];
        }
        if (empty($geneDataset)) {
            return 'Data file is empty';
        }
        $geneDataset = array_unique($geneDataset);
        $sourceId = Source::find()->select('id') -> where(['name' => $source])->one()->id;

        foreach ($geneDataset as $symbol) {
            GeneHelper::saveGeneBySymbol($symbol, $sourceId);
        }

    }

    public function actionFillSourceAbdb($absolutePathToFile)
    {
        if (!file_exists($absolutePathToFile)) {
            return 'Cannot find data file';
        }
        $json = file_get_contents($absolutePathToFile);
        $array = json_decode($json, true);

        if (empty($array['data']) || !is_array($array['data'])) {
            return 'Data file is empty';
        }

        $query = Yii::$app->db->createCommand('SELECT id, symbol FROM gene WHERE symbol IS NOT NULL ')->queryAll();
        $geneList = [];
        foreach ($query as $row) {
            if (!empty($row['symbol'])) {
                $geneList[trim($row['symbol'])] = $row['id'];
            }
        }
        try {
            foreach ($array['data'] as $gene) {
                $symbol = strtoupper(trim($gene[1]));
                if (in_array($symbol, array_keys($geneList))) {
                    $geneToSource = new GeneToSource();
                    $geneToSource->gene_id = $geneList[$symbol];
                    $geneToSource->source_id = 2;
                    $geneToSource->save();
                }
            }
            return 'Source Abdb was successfully filled';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function actionFillSourceGeneAge($absolutePathToFile)
    {
        if (!file_exists($absolutePathToFile)) {
            return 'Cannot find data file';
        }
        $f = fopen($absolutePathToFile, 'r');
        if (fgetcsv($f) == false) {
            return 'Data file is empty';
        }

        $query = Yii::$app->db->createCommand('SELECT id, symbol FROM gene WHERE symbol IS NOT NULL ')->queryAll();
        $geneList = [];
        foreach ($query as $row) {
            if (!empty($row['symbol'])) {
                $geneList[trim($row['symbol'])] = $row['id'];
            }
        }

        try {
            while (($data = fgetcsv($f)) !== false) {
                $symbol = strtoupper(trim($data[1]));
                if (in_array($symbol, array_keys($geneList))) {
                    $geneToSource = new GeneToSource();
                    $geneToSource->gene_id = $geneList[$symbol];
                    $geneToSource->source_id = 1;
                    $geneToSource->save();
                }
            }
            return 'Source GenAge was successfully filled';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function actionMergeGreenForm()
    {
        /* @var $model GeneInterventionToVitalProcess */
        /* @var $modelToUpdate GeneInterventionToVitalProcess */

        $theSameModels = $this->searchTheSameModels(GeneInterventionToVitalProcess::find()->all());

        foreach ($theSameModels as $group) {
            $modelToUpdate = array_shift($group);
            foreach ($group as $model) {
                $modelToUpdate->comment_ru = $modelToUpdate->comment_ru . ' ' . $model->comment_ru;
                $modelToUpdate->comment_en = $modelToUpdate->comment_en . ' ' . $model->comment_en;
                $relationList = GeneInterventionResultToVitalProcess::find()
                    ->where(['gene_intervention_to_vital_process_id' => $model->id])->all();
                foreach ($relationList as $relation) {
                    $this->updateRelationsGreenToProcess($modelToUpdate->id, $relation);
                }
                if ($model->delete()) {
                    Console::output(
                        'Green form id ' . $model->id . ' successfully deleted from table gene_intervention_to_vital_process'
                    );
                }
            }

            if ($modelToUpdate->save(false)) {
                Console::output('Green form id ' . $modelToUpdate->id . ' successfully updated');
            } else {
                Console::output('Attention! Green form id ' . $modelToUpdate->id . ' has not been updated!');
            }
        }
        return Console::output('Successfully merged');
    }

    public function actionPurpleFormSplitSex()
    {
        $this->splitPurpleBySex();
        $this->fillSexPurple();
    }

    public function actionMergePurpleForm()
    {
        $purpleToProcess = GeneralLifespanExperimentToVitalProcess::find()->all();
        if (!empty($purpleToProcess)) {
            Console::output('general_lifespan_experiment_to_vital_process already filled!');
            return;
        }
        $greenList = GeneInterventionToVitalProcess::find()->all();
        $purpleList = GeneralLifespanExperiment::find()->joinWith('lifespanExperiments')->all();

        $greenToPurple = [];
        foreach ($greenList as $green) {
            foreach ($purpleList as $purple) {
                $leList = $purple->relatedRecords['lifespanExperiments'];
                foreach ($leList as $le) {
                    $this->makeMatchesGreenToPurple($le, $green, $purple, $greenToPurple);
                }
            }
        }
        $duplicatePurple = [];
        foreach ($greenToPurple as $greenId => $purple) {
            if (count($purple) > 1) {
                //если у зеленой формы несколько фиолетовых, их мержить не надо, только отдать список генетикам
                $this->searchDuplicatePurple($purple, $duplicatePurple);
            } else {
                $this->createRelationsPurpleToProcess($purple, $greenId);
            }
        }
        VarDumper::dump($duplicatePurple);
    }

    public function actionDoiToMerge()
    {
        $greenList = GeneInterventionToVitalProcess::find()->all();
        $purpleList = GeneralLifespanExperiment::find()->joinWith('lifespanExperiments')->all();

        $greenToPurpleHard = [];
        foreach ($greenList as $green) {
            foreach ($purpleList as $purple) {
                $leList = $purple->relatedRecords['lifespanExperiments'];
                foreach ($leList as $le) {
                    $this->makeMatchesGreenToPurple($le, $green, $purple, $greenToPurpleHard);
                }
            }
        }

        $greenToPurpleSoft = [];
        foreach ($greenList as $green) {
            foreach ($purpleList as $purple) {
                $leList = $purple->relatedRecords['lifespanExperiments'];
                foreach ($leList as $le) {
                    $purpleHash = md5(
                        $purple->reference .
                        $le->gene_id
                    );
                    $greenHash = md5(
                        $green->reference .
                        $green->gene_id
                    );

                    if ($purpleHash == $greenHash) {
                        if (!isset($greenToPurpleSoft[$green->id])) {
                            $greenToPurpleSoft[$green->id] = [];
                        }
                        $greenToPurpleSoft[$green->id][] = $purple;
                    }
                }
            }
        }
        $unmergedDoi = [];
        $unmergedArrayKeys = array_diff(array_keys($greenToPurpleSoft), array_keys($greenToPurpleHard));
        foreach ($unmergedArrayKeys as $key) {
            $doi = $greenToPurpleSoft[$key][0]->reference;
            $geneId = $greenToPurpleSoft[$key][0]->relatedRecords['lifespanExperiments'][0]->gene_id;
            $unmergedDoi[] = $geneId . ' -> ' . $doi;
        }
        VarDumper::dump($unmergedDoi);
    }

    private function createRelationsPurpleToProcess($purple, $greenId)
    {
        $greenToProcess = GeneInterventionResultToVitalProcess::find()->where(
            ['gene_intervention_to_vital_process_id' => $greenId]
        )->all();
        foreach ($greenToProcess as $process) {
            $purpleToProcess = new GeneralLifespanExperimentToVitalProcess();
            $purpleToProcess->attributes = $process->attributes;
            $purpleToProcess->general_lifespan_experiment_id = $purple[0]->id;
            if ($purpleToProcess->save()) {
                Console::output(
                    'Relation purple form -> to process for form id ' . $purpleToProcess->general_lifespan_experiment_id . ', process id ' . $purpleToProcess->vital_process_id . ' successfully created'
                );
            }
        }
    }

    private function searchDuplicatePurple(array $purple, array &$duplicatePurple)
    {
        $geneId = $purple[0]->relatedRecords['lifespanExperiments'][0]->gene_id;
        $doi = $purple[0]->reference;
        $duplicatePurple[] = $geneId . ' -> ' . $doi;
    }

    private function makeMatchesGreenToPurple(
        LifespanExperiment $experiment,
        GeneInterventionToVitalProcess $green,
        GeneralLifespanExperiment $purple,
        &$greenToPurple
    ) {
        //если стоит в зеленой "+/-, -/-" или ничего не стоит, то смержить со всеми фиолетовыми, где совпадает все остальное (без генотипа)
        if ($green->genotype != 3 && $green->genotype != null) {
            $purpleHash = $this->getPurpleHash($purple, $experiment);
            $greenHash = $this->getGreenHash($green);
        } else {
            $purpleHash = $this->getPurpleHash($purple, $experiment, false);
            $greenHash = $this->getGreenHash($green, false);
        }
        if ($purpleHash == $greenHash) {
            if (!isset($greenToPurple[$green->id])) {
                $greenToPurple[$green->id] = [];
            }
            $greenToPurple[$green->id][] = $purple;
        }
    }

    private function splitPurpleBySex()
    {
        $maleFemale = GeneralLifespanExperiment::find()
            ->where(['not', ['lifespan_change_percent_male' => null]])
            ->andWhere(['not', ['lifespan_change_percent_female' => null]])
            ->andWhere(['lifespan_change_percent_common' => null])
            ->all();
        $this->splitTwoSex($maleFemale, 'lifespan_change_percent_male', 'lifespan_change_percent_female');

        $maleCommon = GeneralLifespanExperiment::find()
            ->where(['not', ['lifespan_change_percent_male' => null]])
            ->andWhere(['not', ['lifespan_change_percent_common' => null]])
            ->andWhere(['lifespan_change_percent_female' => null])
            ->all();
        $this->splitTwoSex($maleCommon, 'lifespan_change_percent_male', 'lifespan_change_percent_common');

        $femaleCommon = GeneralLifespanExperiment::find()
            ->where(['not', ['lifespan_change_percent_female' => null]])
            ->andWhere(['not', ['lifespan_change_percent_common' => null]])
            ->andWhere(['lifespan_change_percent_male' => null])
            ->all();
        $this->splitTwoSex($femaleCommon, 'lifespan_change_percent_female', 'lifespan_change_percent_common');

        $maleFemaleCommon = GeneralLifespanExperiment::find()
            ->where(['not', ['lifespan_change_percent_female' => null]])
            ->andWhere(['not', ['lifespan_change_percent_common' => null]])
            ->andWhere(['not', ['lifespan_change_percent_male' => null]])
            ->all();
        $this->splitThreeSex($maleFemaleCommon);
    }

    private function fillSexPurple()
    {
        $models = GeneralLifespanExperiment::find()->all();

        foreach ($models as $model) {
            if ($model->lifespan_change_percent_male !== null) {
                $model->organism_sex_id = 1;
            } elseif ($model->lifespan_change_percent_female !== null) {
                $model->organism_sex_id = 0;
            } elseif ($model->lifespan_change_percent_common !== null) {
                $model->organism_sex_id = 3;
            }
            if ($model->save()) {
                Console::output('Purple form id ' . $model->id . ' successfully updated');
            }
        }
    }

    private function splitTwoSex($parentModels, $attributeToReset, $attributeToInsert)
    {
        foreach ($parentModels as $parentModel) {
            $newGeneralModel = new GeneralLifespanExperiment();
            $newGeneralModel->attributes = $parentModel->attributes;
            $newGeneralModel->$attributeToReset = null;
            if ($newGeneralModel->save()) {
                Console::output('New purple form id ' . $newGeneralModel->id . ' successfully created');
                $this->createNewLifespanExperiment($parentModel->id, $newGeneralModel->id);
            }

            $parentModel->$attributeToInsert = null;
            if ($parentModel->save()) {
                Console::output('Purple form id ' . $parentModel->id . ' successfully updated');
            }
        }
    }

    private function splitThreeSex($models)
    {
        foreach ($models as $model) {
            $this->createNewPurpleForm('female', $model);
            $this->createNewPurpleForm('male', $model);

            $model->lifespan_change_percent_male = null;
            $model->lifespan_change_percent_female = null;

            if ($model->save()) {
                Console::output('Purple form id ' . $model->id . ' successfully updated');
            }
        }
    }

    private function createNewPurpleForm($sex, $parentModel)
    {
        if ($sex == 'female') {
            $attrToReset = 'lifespan_change_percent_male';
        } else {
            $attrToReset = 'lifespan_change_percent_female';
        }
        $model = new GeneralLifespanExperiment();
        $model->attributes = $parentModel->attributes;
        $model->$attrToReset = null;
        $model->lifespan_change_percent_common = null;
        if ($model->save()) {
            Console::output('New purple form id ' . $model->id . ' successfully created');
            $this->createNewLifespanExperiment($parentModel->id, $model->id);
        }
    }

    private function createNewLifespanExperiment($parentModelId, $currentModelId)
    {
        $models = LifespanExperiment::find()->where([
            'general_lifespan_experiment_id' => $parentModelId
        ])->all();

        foreach ($models as $model) {
            $newModel = new LifespanExperiment();
            $newModel->attributes = $model->attributes;
            $newModel->general_lifespan_experiment_id = $currentModelId;
            if ($newModel->save()) {
                Console::output(
                    'Experiment ' . $newModel->id . ' to form id ' . $newModel->general_lifespan_experiment_id . ' successfully created'
                );
            }
        }
    }

    private function getGreenHash(GeneInterventionToVitalProcess $model, $genotype = true): string
    {
        $prepareString =
            $model->reference .
            $model->gene_intervention_method_id .
            $model->model_organism_id .
            $model->organism_line_id .
            $model->sex_of_organism .
            $model->gene_id;

        if ($genotype) {
            $prepareString = $prepareString . $model->genotype;
        }
        return md5($prepareString);
    }

    private function getPurpleHash(
        GeneralLifespanExperiment $general,
        LifespanExperiment $experiment,
        $genotype = true
    ): string {
        $prepareString =
            $general->reference .
            $experiment->gene_intervention_method_id .
            $general->model_organism_id .
            $general->organism_line_id .
            $general->organism_sex_id .
            $experiment->gene_id;

        if ($genotype) {
            $prepareString = $prepareString . $experiment->genotype;
        }
        return md5($prepareString);
    }

    private function searchTheSameModels($models): array
    {
        /* @var $model GeneInterventionToVitalProcess */
        /* @var $searchModel GeneInterventionToVitalProcess */
        $theSameModels = [];
        foreach ($models as $model) {
            foreach ($models as $searchModel) {
                if ($model->id == $searchModel->id) {
                    continue;
                }
                $modelHash = $this->getGreenHash($model);
                $searchModelHash = $this->getGreenHash($searchModel);
                if ($modelHash == $searchModelHash) {
                    if (!isset($theSameModels[$modelHash])) {
                        $theSameModels[$modelHash] = [$model->id => $model];
                    }
                    $theSameModels[$modelHash][$searchModel->id] = $searchModel;
                }
            }
        }
        return $theSameModels;
    }

    private function updateRelationsGreenToProcess(int $modelId, GeneInterventionResultToVitalProcess $relation)
    {
        $theSameRelations = GeneInterventionResultToVitalProcess::find()
            ->where([
                'gene_intervention_to_vital_process_id' => $modelId,
                'intervention_result_for_vital_process_id' => $relation->intervention_result_for_vital_process_id,
                'vital_process_id' => $relation->vital_process_id
            ])->one();
        if ($theSameRelations !== null) {
            $relation->delete();
            return;
        }
        $relation->gene_intervention_to_vital_process_id = $modelId;
        if ($relation->save()) {
            Console::output(
                'Relation id ' . $relation->id . ' was updated (table gene_intervention_result_to_vital_process)'
            );
        }
    }


}

