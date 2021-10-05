<?php
/** @var $geneInterventionToVitalProcess \app\models\GeneInterventionToVitalProcess */

use app\models\InterventionResultForVitalProcess;

?>
<div class="protein-activity green js-intervention-to-vital-process js-gene-link-section">
    <div class="js-intervention-to-vital-process-block js-gene-link-block">
        <div class="row form-row">
            <div class="col-xs-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $geneInterventionToVitalProcess,
                    'attribute' => '[' . $geneInterventionToVitalProcess->id . ']gene_intervention_id',
                    'data' => \app\models\GeneIntervention::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Метод',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'tags' => Yii::$app->user->can('admin'),
                        'tokenSeparators' => ['##'],
                        'containerCssClass' => 'green',
                        'dropdownCssClass' => 'green',
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $geneInterventionToVitalProcess,
                    'attribute' => '[' . $geneInterventionToVitalProcess->id . ']intervention_result_for_vital_process_id',
                    'data' => InterventionResultForVitalProcess::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Результат',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'tags' => Yii::$app->user->can('admin'),
                        'tokenSeparators' => ['##'],
                        'containerCssClass' => 'green',
                        'dropdownCssClass' => 'green',
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $geneInterventionToVitalProcess,
                    'attribute' => '[' . $geneInterventionToVitalProcess->id . ']vital_process_id',
                    'data' => \app\models\VitalProcess::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Процесс',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'tags' => Yii::$app->user->can('admin'),
                        'tokenSeparators' => ['##'],
                        'containerCssClass' => 'green',
                        'dropdownCssClass' => 'green',
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $geneInterventionToVitalProcess,
                    'attribute' => '[' . $geneInterventionToVitalProcess->id . ']model_organism_id',
                    'data' => \app\models\ModelOrganism::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Объект',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'tags' => true,
                        'tokenSeparators' => ['##'],
                        'containerCssClass' => 'green',
                        'dropdownCssClass' => 'green',
                    ],
                ]);
                ?>
            </div>
        </div>
        <div class="row form-row">
            <div class="col-xs-3 col-sm-4">
                <?= \yii\bootstrap\Html::activeInput('text', $geneInterventionToVitalProcess, '[' . $geneInterventionToVitalProcess->id . ']age', ['class' => 'form-control age_unit', 'placeholder' => 'Возраст']) ?>
            </div>
            <div class="col-xs-3 col-sm-4">
                <?= \kartik\select2\Select2::widget([
                    'model' => $geneInterventionToVitalProcess,
                    'attribute' => '[' . $geneInterventionToVitalProcess->id . ']age_unit',
                    'data' => [1 => 'дней', 4 => 'недель', 2 => 'месяцев', 3 => 'лет'],
                    'options' => [
                        'placeholder' => 'Ед. изм. возраста',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'containerCssClass' => 'green form_age_unit',
                        'dropdownCssClass' => 'green',
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-3 col-sm-4">
                <?= \kartik\select2\Select2::widget([
                    'model' => $geneInterventionToVitalProcess,
                    'attribute' => '[' . $geneInterventionToVitalProcess->id . ']sex_of_organism',
                    'data' => ['' => '', 0 => 'женский', 1 => 'мужской', 2 => 'оба пола'],
                    'options' => [
                        'placeholder' => 'Пол',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'containerCssClass' => 'green',
                        'dropdownCssClass' => 'green',
                    ],
                ]);
                ?>
            </div>
        </div>
        <div class="row form-row">
            <div class="col-xs-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $geneInterventionToVitalProcess,
                    'attribute' => '[' . $geneInterventionToVitalProcess->id . ']organism_line_id',
                    'data' => \app\models\OrganismLine::getAllNamesByOrganisms(),
                    'options' => [
                        'placeholder' => 'Линия',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'tags' => true,
                        'tokenSeparators' => ['##'],
                        'containerCssClass' => 'green',
                        'dropdownCssClass' => 'green',
                    ],
                ]);
                ?>
            </div>

            <div class="col-xs-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $geneInterventionToVitalProcess,
                    'attribute' => '[' . $geneInterventionToVitalProcess->id . ']genotype',
                    'data' => [0 => '', 1 => '+/-', 2 => '-/-', 3 => '+/-, -/-'],
                    'options' => [
                        'placeholder' => 'Генотип',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-3">
                <?= \yii\bootstrap\Html::activeInput('text', $geneInterventionToVitalProcess, '[' . $geneInterventionToVitalProcess->id . ']reference', ['class' => 'form-control', 'placeholder' => 'DOI (пример: 10.1111/acel.12216)']) ?>
            </div>
            <div class="col-xs-3">
                <?= \yii\bootstrap\Html::activeInput('text', $geneInterventionToVitalProcess, '[' . $geneInterventionToVitalProcess->id . ']pmid', ['class' => 'form-control', 'placeholder' => 'PMID (пример: 34225353)']) ?>
            </div>
        </div>

        <div class="row form-row">
            <div class="col-xs-12 col-sm-6">
                <?= \yii\bootstrap\Html::activeTextarea($geneInterventionToVitalProcess, '[' . $geneInterventionToVitalProcess->id . ']comment_ru', ['class' => 'form-control', 'placeholder' => 'Дополнительная информация']) ?>
            </div>
            <div class="col-xs-12 col-sm-6">
                <?= \yii\bootstrap\Html::activeTextarea($geneInterventionToVitalProcess, '[' . $geneInterventionToVitalProcess->id . ']comment_en', ['class' => 'form-control', 'placeholder' => 'Дополнительная информация EN']) ?>
            </div>
        </div>
    </div>

    <div class="row form-row">
        <div class="col-xs-12 delete-protein"><?= \yii\bootstrap\Html::activeCheckbox($geneInterventionToVitalProcess, '[' . $geneInterventionToVitalProcess->id . ']delete', ['class' => 'js-delete']) ?></div>
    </div>
</div>