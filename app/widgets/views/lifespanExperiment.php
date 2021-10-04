<?php
/** @var $lifespanExperiment \app\models\LifespanExperiment */
/** @var $generalLifespanExperimentId int */
/** @var $currentGeneId int */
/** @var $type string */
?>
<div class="protein-activity js-lifespan-experiment js-gene-link-section <?=($lifespanExperiment->gene_id != $currentGeneId) ? 'white' : ''?>">
    <div class="js-lifespan-experiment-block js-gene-link-block">
        <?=($lifespanExperiment->gene_id != $currentGeneId) ? ($lifespanExperiment->type == 'control' ? 'Воздействие в контроле и в эксперименте' : 'Воздействие в эксперименте') : ''?>
        <div class="row form-row">
            <!--            --><?php //var_dump($lifespanExperiment->gene_id, $currentGeneId); ?>
            <?php if ($lifespanExperiment->gene_id != $currentGeneId): ?>
                <div class="col-xs-6 col-md-2">
                    <?= \kartik\select2\Select2::widget([
                        'model' => $lifespanExperiment,
                        'attribute' => '[' . $lifespanExperiment->id . ']gene_id',
                        'data' => \app\models\Gene::getAllNamesAsArray(),
                        'options' => [
                            'placeholder' => 'Ген',
                            'multiple' => false
                        ],
                        'pluginOptions' => [
                            'allowClear' => false,
//                        'tags' => Yii::$app->user->can('admin'),
                            'tokenSeparators' => ['##'],
                        ],
                    ]);
                    ?>
                </div>
            <?php endif; ?>
            <?= \yii\helpers\Html::hiddenInput('LifespanExperiment[' . $lifespanExperiment->id . '][type]', $lifespanExperiment->type) ?>
            <?= \yii\helpers\Html::hiddenInput('LifespanExperiment[' . $lifespanExperiment->id . '][general_lifespan_experiment_id]', $lifespanExperiment->general_lifespan_experiment_id) ?>
            <div class="col-xs-6 col-md-4">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']experiment_main_effect_id',
                    'data' => \app\models\ExperimentMainEffect::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Основной эффект',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'tags' => Yii::$app->user->can('admin'),
                        'tokenSeparators' => ['##'],
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-6 col-md-4">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']geneInterventionWay',
                    'data' => \app\models\GeneInterventionWay::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Способ воздействия',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'tags' => Yii::$app->user->can('admin'),
                        'tokenSeparators' => ['##'],
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-6 col-md-4">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']gene_intervention_method_id',
                    'data' => \app\models\GeneInterventionMethod::getAllNamesByWays(),
                    'options' => [
                        'placeholder' => 'Метод',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'tags' => Yii::$app->user->can('admin'),
                        'tokenSeparators' => ['##'],
                    ],
                ]);
                ?>
            </div>
        </div>
        <div class="row form-row">
            <div class="col-xs-6 col-sm-4">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']genotype',
                    'data' => [0 => '', 1 => '+/-', 2 => '-/-'],
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
            <div class="col-xs-6 col-md-2">
                <?= \yii\bootstrap\Html::activeCheckbox($lifespanExperiment, '[' . $lifespanExperiment->id . ']tissue_specificity') ?>
            </div>
            <div class="col-xs-6 col-md-3">
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
                        'allowClear' => false,
                    ],
                ]);
                ?>
            </div>
        </div>
        <div class="row form-row">
            <div class="col-xs-6 col-md-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']active_substance_id',
                    'data' => \app\models\ActiveSubstance::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Вещество',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'tags' => Yii::$app->user->can('admin'),
                        'tokenSeparators' => ['##'],
                        'allowClear' => false,
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-6 col-md-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']treatment_period_id',
                    'data' => \app\models\ExperimentTreatmentPeriod::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Периодичность',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'tags' => Yii::$app->user->can('admin'),
                        'tokenSeparators' => ['##'],
                        'allowClear' => false,
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
                        'tags' => Yii::$app->user->can('admin'),
                        'tokenSeparators' => ['##'],
                        'allowClear' => false,
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
                        'tags' => Yii::$app->user->can('admin'),
                        'tokenSeparators' => ['##'],
                        'allowClear' => false,
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
                        'tags' => Yii::$app->user->can('admin'),
                        'tokenSeparators' => ['##'],
                        'allowClear' => false,
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
                        'tags' => Yii::$app->user->can('admin'),
                        'tokenSeparators' => ['##'],
                        'allowClear' => false,
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


