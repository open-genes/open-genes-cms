<?php
/** @var $lifespanExperiment \app\models\LifespanExperiment */
?>
<div class="protein-activity js-lifespan-experiment js-gene-link-section">
    <div class="js-lifespan-experiment-block js-gene-link-block">
        <b>Контроль</b>
        <div class="row form-row">
            <div class="col-xs-6 col-md-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']model_organism_id',
                    'data' => \app\models\ModelOrganism::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Организм',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'tags' => true,
                        'tokenSeparators' => ['##'],
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-6 col-md-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']organism_line_id',
                    'data' => \app\models\OrganismLine::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Линия',
                        'multiple' => false,
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
                    'attribute' => '[' . $lifespanExperiment->id . ']organism_sex_id',
                    'data' => \app\models\OrganismSex::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Пол',
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
            <div class="col-xs-6 col-md-3">
                <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']control_number', ['class' => 'form-control age_unit', 'placeholder' => 'N (количество)']) ?>
            </div>
        </div>
        <b>Эксперимент</b>
        <div class="row form-row">
            <div class="col-xs-6 col-md-2">
                <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']experiment_number', ['class' => 'form-control age_unit', 'placeholder' => 'N (количество)']) ?>
            </div>
            <div class="col-xs-6 col-md-2">
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
            <div class="col-xs-6 col-md-2">
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
                        'allowClear' => false,
                        'tags' => Yii::$app->user->can('admin'),
                        'tokenSeparators' => ['##'],
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-6 col-md-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']tissuesIds',
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

        <b>Результаты</b>
        <div class="row form-row">
            <div class="col-xs-6 col-md-3">
                <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']expression_change', ['class' => 'form-control age_unit', 'placeholder' => '% изменения экспрессии']) ?>
            </div>
            <div class="col-xs-6 col-md-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']changed_expression_tissue_id',
                    'data' => \app\models\Sample::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Ткань',
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
                    'attribute' => '[' . $lifespanExperiment->id . ']intervention_result_id',
                    'data' => \app\models\InterventionResultForLongevity::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Результат',
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
        <b>Продолжительность жизни</b>
        <div class="row form-row">
            <div class="col-xs-6 col-md-2">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']lifespan_change_time_unit_id',
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
            <div class="col-xs-6 col-md-10">
                <div class="row form-row">
                    <div class="col-xs-6 col-md-4">
                        Продолжительность жизни контроля
                    </div>
                    <div class="col-xs-6 col-md-2">
                        <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']control_lifespan_min', ['class' => 'form-control age_unit', 'placeholder' => 'Минимум']) ?>
                    </div>
                    <div class="col-xs-6 col-md-2">
                        <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']control_lifespan_mean', ['class' => 'form-control age_unit', 'placeholder' => 'Среднее']) ?>
                    </div>
                    <div class="col-xs-6 col-md-2">
                        <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']control_lifespan_median', ['class' => 'form-control age_unit', 'placeholder' => 'Медиана']) ?>
                    </div>
                    <div class="col-xs-6 col-md-2">
                        <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']control_lifespan_max', ['class' => 'form-control age_unit', 'placeholder' => 'Максимум']) ?>
                    </div>
                </div>
                <div class="row form-row">
                    <div class="col-xs-6 col-md-4">
                        Продолжительность жизни эксперимента
                    </div>
                    <div class="col-xs-6 col-md-2">
                        <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']experiment_lifespan_min', ['class' => 'form-control age_unit', 'placeholder' => 'Минимум']) ?>
                    </div>
                    <div class="col-xs-6 col-md-2">
                        <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']experiment_lifespan_mean', ['class' => 'form-control age_unit', 'placeholder' => 'Среднее']) ?>
                    </div>
                    <div class="col-xs-6 col-md-2">
                        <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']experiment_lifespan_median', ['class' => 'form-control age_unit', 'placeholder' => 'Медиана']) ?>
                    </div>
                    <div class="col-xs-6 col-md-2">
                        <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']experiment_lifespan_max', ['class' => 'form-control age_unit', 'placeholder' => 'Максимум']) ?>
                    </div>
                </div>
            </div>
            <div class="row form-row">
                <div class="col-xs-6 col-md-2"><b>Изменение (%)</b></div>
                <div class="col-xs-6 col-md-10">
                    <div class="col-xs-6 col-md-4">&nbsp;</div>
                    <div class="col-xs-6 col-md-2">
                        <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']control_lifespan_min', ['class' => 'form-control age_unit', 'placeholder' => 'Минимум']) ?>
                    </div>
                    <div class="col-xs-6 col-md-2">
                        <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']control_lifespan_mean', ['class' => 'form-control age_unit', 'placeholder' => 'Среднее']) ?>
                    </div>
                    <div class="col-xs-6 col-md-2">
                        <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']control_lifespan_median', ['class' => 'form-control age_unit', 'placeholder' => 'Медиана']) ?>
                    </div>
                    <div class="col-xs-6 col-md-2">
                        <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']control_lifespan_max', ['class' => 'form-control age_unit', 'placeholder' => 'Максимум']) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row form-row">
            <div class="col-xs-6 col-sm-2">
                <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']age', ['class' => 'form-control form_age', 'placeholder' => 'Возраст']) ?>
            </div>
            <div class="col-xs-6 col-sm-2">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']age_unit',
                    'data' => \app\models\TreatmentTimeUnit::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Ед. изм. возраста',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'containerCssClass' => 'form_age_unit',
                    ],
                ]);
                ?>
            </div>
            <div class="col-sm-2">
                <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']lifespan_change_percent_male', ['class' => 'form-control', 'placeholder' => 'Изменение (%) муж']) ?>
            </div>
            <div class="col-sm-2">
                <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']lifespan_change_percent_female', ['class' => 'form-control', 'placeholder' => 'Изменение (%) жен']) ?>
            </div>
            <div class="col-sm-2">
                <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']lifespan_change_percent_common', ['class' => 'form-control', 'placeholder' => 'Изменение (%) общее']) ?>
            </div>
        </div>
        <div class="row form-row">

            <div class="col-sm-3">
                <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']reference', ['class' => 'form-control', 'placeholder' => 'DOI (пример: 10.1111/acel.12216)']) ?>
            </div>
            <div class="col-sm-3">
                <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']pmid', ['class' => 'form-control', 'placeholder' => 'PMID (пример: 34225353)']) ?>
            </div>
        </div>
        <div class="row form-row">
            <div class="col-xs-12 col-sm-6">
                <?= \yii\bootstrap\Html::activeTextarea($lifespanExperiment, '[' . $lifespanExperiment->id . ']comment_ru', ['class' => 'form-control', 'placeholder' => 'Дополнительная информация']) ?>
            </div>
            <div class="col-xs-12 col-sm-6">
                <?= \yii\bootstrap\Html::activeTextarea($lifespanExperiment, '[' . $lifespanExperiment->id . ']comment_en', ['class' => 'form-control', 'placeholder' => 'Дополнительная информация EN']) ?>
            </div>
        </div>
    </div>
</div>

<div class="row form-row">
    <div class="col-xs-12 delete-protein"><?= \yii\bootstrap\Html::activeCheckbox($lifespanExperiment, '[' . $lifespanExperiment->id . ']delete', ['class' => 'js-delete']) ?></div>
</div>
</div>