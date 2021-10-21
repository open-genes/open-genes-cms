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
                    'attribute' => '[' . $lifespanExperiment->id . ']geneInterventionWay',
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
                    'data' => \app\models\GeneInterventionMethod::getAllNamesByWays(),
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
                    'data' => [0 => '', 1 => '+/-', 2 => '-/-', 3 => '+/++', 4 => '++/++'],
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
            <div class="col-xs-6 col-md-8" style="float: right;">
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
            <div class="col-xs-6 col-md-2">
                <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']active_substance_daily_dose', ['class' => 'form-control age_unit', 'placeholder' => 'Дневная доза']) ?>
            </div>
            <div class="col-xs-6 col-md-2">
                <div class="col-xs-6 col-md-3" style="padding: 6px 0px 0px 9px;">
                    x 10^
                </div>
                <div class="col-xs-3 col-md-9">
                    <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']daily_dose_sci_not_degree', ['class' => 'form-control age_unit', 'placeholder' => 'Степень']) ?>
                </div>
            </div>
            <div class="col-xs-6 col-md-2">
                <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']active_substance_daily_doses_number', ['class' => 'form-control age_unit', 'placeholder' => 'Кол-во доз в день']) ?>
            </div>
            <div class="col-xs-6 col-md-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']active_substance_dosage_unit_id',
                    'data' => \app\models\ActiveSubstanceDosageUnit::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Ед.изм. дозировки',
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
            <div class="col-xs-6 col-md-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']active_substance_delivery_way_id',
                    'data' => \app\models\ActiveSubstanceDeliveryWay::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Способ доставки препарата',
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
            <div class="col-xs-6 col-md-2">
                <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']treatment_start', ['class' => 'form-control age_unit', 'placeholder' => 'Начало']) ?>
            </div>
            <div class="col-xs-6 col-md-2">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']treatment_start_time_unit_id',
                    'data' => \app\models\TreatmentTimeUnit::getAllNamesAsArray(),
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
                    'data' => \app\models\TreatmentTimeUnit::getAllNamesAsArray(),
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


