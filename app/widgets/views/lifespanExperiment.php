<?php
/** @var $lifespanExperiment \app\models\LifespanExperiment */
/** @var $generalLifespanExperimentId int */
/** @var $currentGeneId int */
/** @var $type string */
?>
<div class="gene-modulation js-lifespan-experiment js-gene-link-section
<?= ($lifespanExperiment->gene_id != $currentGeneId) ? '__padding-0' : '' ?>">
    <div class="js-lifespan-experiment-block js-gene-link-block experiment-block
        <?= ($lifespanExperiment->gene_id != $currentGeneId) ? 'experiment-block--extra-experiment' : '' ?>">
        <? if ($lifespanExperiment->gene_id != $currentGeneId): ?>
            <div class="experiment-block__title">Воздействие на другой ген</div>
        <? endif; ?>
        <? if ($lifespanExperiment->gene_id != $currentGeneId) { ?>
            <div class="hint hint--primary">
                <?= $lifespanExperiment->type == 'control'
                    ? 'Воздействия на любой ген, кроме аннотируемого, которое есть и в контроле и в эксперименте'
                    : 'Воздействия на любой ген, кроме аннотируемого, которое есть только в эксперименте' ?>
            </div>
        <? } ?>


        <?php //var_dump($lifespanExperiment->gene_id, $currentGeneId); ?>
        <?php if ($lifespanExperiment->gene_id != $currentGeneId): ?>
            <div class="row form-row">
                <div class="col-xs-6 col-md-3">
                    <?php 
                    $genes = \app\models\Gene::getAllNamesAsArray();
                    unset($genes[$currentGeneId]);
                    echo \kartik\select2\Select2::widget([
                        'model' => $lifespanExperiment,
                        'attribute' => '[' . $lifespanExperiment->id . ']gene_id',
                        'data' => $genes,
                        'options' => [
                            'placeholder' => 'Ген',
                            'multiple' => false
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
//                        'tags' => true,
                            'tokenSeparators' => ['##'],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        <?php else: ?>
            <?= \yii\helpers\Html::hiddenInput('LifespanExperiment[' . $lifespanExperiment->id . '][gene_id]', $lifespanExperiment->gene_id) ?>
        <?php endif; ?>
        <div class="row form-row">
            <?= \yii\helpers\Html::hiddenInput('LifespanExperiment[' . $lifespanExperiment->id . '][type]', $lifespanExperiment->type) ?>
            <?= \yii\helpers\Html::hiddenInput('LifespanExperiment[' . $lifespanExperiment->id . '][general_lifespan_experiment_id]', $lifespanExperiment->general_lifespan_experiment_id) ?>
            <div class="col-xs-6 col-md-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']experiment_main_effect_id',
                    'data' => \app\models\ExperimentMainEffect::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Основной эффект',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'tags' => true,
                        'tokenSeparators' => ['##'],
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-6 col-md-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']gene_intervention_way_id',
                    'data' => \app\models\GeneInterventionWay::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Способ воздействия',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'tags' => true,
                        'tokenSeparators' => ['##'],
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-6 col-md-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']gene_intervention_method_id',
                    'data' => \app\models\GeneInterventionMethod::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Метод',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'tags' => true,
                        'tokenSeparators' => ['##'],
                    ],
                ]);
                ?>
            </div>

            <div class="col-xs-6 col-sm-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']genotype',
                    'data' => \app\models\Genotype::getAllNames(),
                    'options' => [
                        'placeholder' => 'Генотип',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'tags' => true,
                    ],
                ]);
                ?>
            </div>
        </div>

        <div class="row form-row">
            <div class="col-xs-6 col-md-4 checkbox-wrapper">
                <?= \yii\bootstrap\Html::activeCheckbox($lifespanExperiment, '[' . $lifespanExperiment->id . ']tissue_specificity') ?>
            </div>

            <div class="col-xs-6 col-md-8">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']tissuesIdsArray',
                    'data' => \app\models\Sample::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Ткань',
                        'multiple' => true,
                    ],
                    'pluginOptions' => [
                        'tags' => true,
                        'tokenSeparators' => ['##'],
                        'allowClear' => true,
                    ],
                ]);
                ?>
            </div>
        </div>
        <div class="row form-row">
            <div class="col-xs-6 col-md-4 checkbox-wrapper">
                <?= \yii\bootstrap\Html::activeCheckbox($lifespanExperiment, '[' . $lifespanExperiment->id . ']mutation_induction') ?>
            </div>
            <div class="col-xs-6 col-md-8">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']active_substance_id',
                    'data' => \app\models\ActiveSubstance::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Препарат',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'tags' => true,
                        'tokenSeparators' => ['##'],
                        'allowClear' => true,
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-6 col-md-6">
                <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']tissue_specific_promoter', ['class' => 'form-control tissue_specific_promoter', 'placeholder' => 'Тканеспецифичный промотер']) ?>
            </div>
            <div class="col-xs-6 col-md-6">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']treatment_period_id',
                    'data' => \app\models\ExperimentTreatmentPeriod::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Периодичность',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'tags' => true,
                        'tokenSeparators' => ['##'],
                        'allowClear' => true,
                    ],
                ]);
                ?>
            </div>
        </div>
        <div class="row form-row">
                <div class="col-xs-12 col-sm-6">
                    <?= \yii\bootstrap\Html::activeTextarea($lifespanExperiment, '[' . $lifespanExperiment->id . ']description_of_therapy_ru', ['class' => 'form-control', 'placeholder' => 'Описание курса терапии']) ?>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <?= \yii\bootstrap\Html::activeTextarea($lifespanExperiment, '[' . $lifespanExperiment->id . ']description_of_therapy_en', ['class' => 'form-control', 'placeholder' => 'Описание курса терапии EN']) ?>
                </div>
        </div>
        <div class="row form-row">
            <div class="col-xs-6 col-md-2">
                <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']treatment_start', ['class' => 'form-control age_unit', 'placeholder' => 'Начало']) ?>
            </div>
            <div class="col-xs-6 col-md-2">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']treatment_start_time_unit_id',
                    'data' => \app\models\TimeUnit::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Ед.изм. времени',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'tags' => true,
                        'tokenSeparators' => ['##'],
                        'allowClear' => true,
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-6 col-md-2">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']treatment_start_stage_of_development_id',
                    'data' => \app\models\TreatmentStageOfDevelopment::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Точка отсчета',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'tags' => true,
                        'tokenSeparators' => ['##'],
                        'allowClear' => true,
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-6 col-md-2">
                <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']treatment_end', ['class' => 'form-control age_unit', 'placeholder' => 'Конец']) ?>
            </div>
            <div class="col-xs-6 col-md-2">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']treatment_end_time_unit_id',
                    'data' => \app\models\TimeUnit::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Ед.изм. времени',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'tags' => true,
                        'tokenSeparators' => ['##'],
                        'allowClear' => true,
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-6 col-md-2">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']treatment_end_stage_of_development_id',
                    'data' => \app\models\TreatmentStageOfDevelopment::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Точка отсчета',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'tags' => true,
                        'tokenSeparators' => ['##'],
                        'allowClear' => true,
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
    <div class="row form-row">
        <div class="col-xs-12 delete-protein"><?= ($lifespanExperiment->gene_id != $currentGeneId) ? \yii\bootstrap\Html::activeCheckbox($lifespanExperiment, '[' . $lifespanExperiment->id . ']delete', ['class' => 'js-delete']) : '' ?></div>
    </div>
</div>


