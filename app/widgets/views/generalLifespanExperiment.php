<?php
/** @var $generalLifespanExperiment \app\models\GeneralLifespanExperiment */
/** @var $currentGeneId int */
?>
<div class="protein-activity js-lifespan-experiment js-gene-link-section">
    <div class="js-lifespan-experiment-block js-gene-link-block">
        <?= \yii\helpers\Html::hiddenInput('GeneralLifespanExperiment[' . $generalLifespanExperiment->id . '][currentGeneId]', $currentGeneId) ?>
        <h2 class="section-title">
            Данные о выборке
        </h2>
        <div class="row form-row">
            <div class="col-xs-6 col-md-4">
<!--                --><?php //var_dump($generalLifespanExperiment); die;?>
                <?= \kartik\select2\Select2::widget([
                    'model' => $generalLifespanExperiment,
                    'attribute' => '[' . $generalLifespanExperiment->id . ']model_organism_id',
                    'data' => \app\models\ModelOrganism::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Организм',
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
            <div class="col-xs-6 col-md-4">
                <?= \kartik\select2\Select2::widget([
                    'model' => $generalLifespanExperiment,
                    'attribute' => '[' . $generalLifespanExperiment->id . ']organism_line_id',
                    'data' => \app\models\OrganismLine::getAllNamesByOrganisms(),
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
            <div class="col-xs-6 col-md-4">
                <?= \kartik\select2\Select2::widget([
                    'model' => $generalLifespanExperiment,
                    'attribute' => '[' . $generalLifespanExperiment->id . ']organism_sex_id',
                    'data' => \app\models\OrganismSex::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Пол',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'tags' => Yii::$app->user->can('admin'),
                        'tokenSeparators' => ['##'],
                    ],
                ]);
                ?>
            </div>
        </div>
        <div class="row form-row">
            <div class="col-xs-6 col-md-2">
                <?= \yii\bootstrap\Html::activeInput('text', $generalLifespanExperiment, '[' . $generalLifespanExperiment->id . ']control_number', ['class' => 'form-control', 'placeholder' => 'N контроля']) ?>
            </div>
            <div class="col-xs-6 col-md-2">
                <?= \yii\bootstrap\Html::activeInput('text', $generalLifespanExperiment, '[' . $generalLifespanExperiment->id . ']experiment_number', ['class' => 'form-control', 'placeholder' => 'N эксперимента']) ?>
            </div>
            <div class="col-xs-6 col-md-2">
                <?= \yii\bootstrap\Html::activeInput('text', $generalLifespanExperiment, '[' . $generalLifespanExperiment->id . ']organism_number_in_cage', ['class' => 'form-control', 'placeholder' => 'N животных в клетке/чашке']) ?>
            </div>
            <div class="col-xs-6 col-md-2">
                <?= \yii\bootstrap\Html::activeInput('text', $generalLifespanExperiment, '[' . $generalLifespanExperiment->id . ']temperature_from', ['class' => 'form-control', 'placeholder' => 'Температура ℃ - от']) ?>
            </div>
            <div class="col-xs-6 col-md-2">
                <?= \yii\bootstrap\Html::activeInput('text', $generalLifespanExperiment, '[' . $generalLifespanExperiment->id . ']temperature_to', ['class' => 'form-control', 'placeholder' => 'Температура ℃ - до']) ?>
            </div>
            <div class="col-xs-6 col-md-2">
                <?= \kartik\select2\Select2::widget([
                    'model' => $generalLifespanExperiment,
                    'attribute' => '[' . $generalLifespanExperiment->id . ']diet_id',
                    'data' => \app\models\Diet::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Диета',
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
        </div>

        <div class="row form-row no-margins">
            <div class="form-group">
                <div class="js-lifespan-experiments-control">
                    <?php foreach ($generalLifespanExperiment->getLifespanExperimentsForForm('control') as $lifespanExperiment): ?>
                        <?= \app\widgets\LifespanExperimentWidget::widget(['model' => $lifespanExperiment, 'currentGeneId' => $currentGeneId]) ?>
                    <?php endforeach; ?>
                </div>
                <?= \yii\helpers\Html::button('+ Воздействие в контроле и эксперименте', [
                    'class' => 'btn btn-add add-protein-activity js-add-lifespan-experiment-control',
                    'currentGeneId' => $currentGeneId,
                    'generalLifespanExperimentId' => $generalLifespanExperiment->id
                ]) ?>
            </div>
        </div>

        <h2 class="section-title">
            Эксперимент
        </h2>
        <div class="row form-row">
        </div>
        <div class="row form-row">
            <div class="js-lifespan-experiments-gene">
                <div class="row form-row">
                    <?php foreach ($generalLifespanExperiment->getLifespanExperimentsForForm('experiment') as $lifespanExperiment): ?>
                        <?= \app\widgets\LifespanExperimentWidget::widget(['model' => $lifespanExperiment, 'currentGeneId' => $currentGeneId]) ?>
                    <?php endforeach; ?>
                </div>

                <?= \yii\helpers\Html::button('+ Воздействие в эксперименте', [
                    'class' => 'btn btn-add btn-add--padded add-protein-activity js-add-lifespan-experiment-gene',
                    'currentGeneId' => $currentGeneId,
                    'generalLifespanExperimentId' => $generalLifespanExperiment->id
                ]) ?>
            </div>
        </div>


        <div class="row form-row">
            <h2 class="col-xs-12 section-title">
                Результаты
            </h2>
            <div class="col-xs-6 col-md-3">
                <?= \yii\bootstrap\Html::activeInput('text', $generalLifespanExperiment,
                    '[' . $generalLifespanExperiment->id . ']expression_change',
                    ['class' => 'form-control age_unit', 'placeholder' => '% изменения активности гена']) ?>
            </div>
            <div class="col-xs-6 col-sm-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $generalLifespanExperiment,
                    'attribute' => '[' . $generalLifespanExperiment->id . ']measurement_type',
                    'data' => [1 => 'уровень мРНК', 2 => 'уровень белка', 3 => 'количество клеток, экспрессирующих ген', 4 => 'активность белка'],
                    'options' => [
                        'placeholder' => 'Вид изменения',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-6 col-md-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $generalLifespanExperiment,
                    'attribute' => '[' . $generalLifespanExperiment->id . ']changed_expression_tissue_id',
                    'data' => \app\models\Sample::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Ткань',
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
                    'model' => $generalLifespanExperiment,
                    'attribute' => '[' . $generalLifespanExperiment->id . ']intervention_result_id',
                    'data' => \app\models\InterventionResultForLongevity::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Результат',
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

        <div class="row form-row lifespan-section">
            <div class="col-xs-12 col-md-3">
                <h3 class="section-title">Продолжительность жизни</h3>
                <?= \kartik\select2\Select2::widget([
                    'model' => $generalLifespanExperiment,
                    'attribute' => '[' . $generalLifespanExperiment->id . ']lifespan_change_time_unit_id',
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
            <div class="col-xs-12 col-md-9 lifespan-section__values">
                <div class="row form-row">
                    <div class="col-xs-12 col-md-4">
                        Продолжительность жизни контроля
                    </div>
                    <div class="col-xs-6 col-md-2">
                        <?= \yii\bootstrap\Html::activeInput('text', $generalLifespanExperiment, '[' . $generalLifespanExperiment->id . ']control_lifespan_min', ['class' => 'form-control age_unit', 'placeholder' => 'Минимум']) ?>
                    </div>
                    <div class="col-xs-6 col-md-2">
                        <?= \yii\bootstrap\Html::activeInput('text', $generalLifespanExperiment, '[' . $generalLifespanExperiment->id . ']control_lifespan_mean', ['class' => 'form-control age_unit', 'placeholder' => 'Среднее']) ?>
                    </div>
                    <div class="col-xs-6 col-md-2">
                        <?= \yii\bootstrap\Html::activeInput('text', $generalLifespanExperiment, '[' . $generalLifespanExperiment->id . ']control_lifespan_median', ['class' => 'form-control age_unit', 'placeholder' => 'Медиана']) ?>
                    </div>
                    <div class="col-xs-6 col-md-2">
                        <?= \yii\bootstrap\Html::activeInput('text', $generalLifespanExperiment, '[' . $generalLifespanExperiment->id . ']control_lifespan_max', ['class' => 'form-control age_unit', 'placeholder' => 'Максимум']) ?>
                    </div>
                </div>
                <div class="row form-row">
                    <div class="col-xs-12 col-md-4">
                        Продолжительность жизни эксперимента
                    </div>
                    <div class="col-xs-6 col-md-2">
                        <?= \yii\bootstrap\Html::activeInput('text', $generalLifespanExperiment, '[' . $generalLifespanExperiment->id . ']experiment_lifespan_min', ['class' => 'form-control age_unit', 'placeholder' => 'Минимум']) ?>
                    </div>
                    <div class="col-xs-6 col-md-2">
                        <?= \yii\bootstrap\Html::activeInput('text', $generalLifespanExperiment, '[' . $generalLifespanExperiment->id . ']experiment_lifespan_mean', ['class' => 'form-control age_unit', 'placeholder' => 'Среднее']) ?>
                    </div>
                    <div class="col-xs-6 col-md-2">
                        <?= \yii\bootstrap\Html::activeInput('text', $generalLifespanExperiment, '[' . $generalLifespanExperiment->id . ']experiment_lifespan_median', ['class' => 'form-control age_unit', 'placeholder' => 'Медиана']) ?>
                    </div>
                    <div class="col-xs-6 col-md-2">
                        <?= \yii\bootstrap\Html::activeInput('text', $generalLifespanExperiment, '[' . $generalLifespanExperiment->id . ']experiment_lifespan_max', ['class' => 'form-control age_unit', 'placeholder' => 'Максимум']) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row form-row change-section">
            <div class="col-xs-12 col-md-3">
                <h3 class="section-title">Изменение (%)</h3>
            </div>
            <div class="col-xs-12 col-md-9">
                <div class="row form-row">
<!--                    <div class="col-xs-6 col-md-1 hidden-xs hidden-sm">&nbsp;</div>-->
                    <div class="col-xs-6 col-md-1" style="padding-right: 0;">
                        <?= \yii\bootstrap\Html::activeInput('text', $generalLifespanExperiment, '[' . $generalLifespanExperiment->id . ']lifespan_min_change', ['class' => 'form-control age_unit', 'placeholder' => 'Мин.']) ?>
                    </div>
                    <div class="col-xs-6 col-md-2" style="padding-left: 0;">
                        <?= \kartik\select2\Select2::widget([
                            'model' => $generalLifespanExperiment,
                            'attribute' => '[' . $generalLifespanExperiment->id . ']lifespan_min_change_stat_sign_id',
                            'data' => \app\models\StatisticalSignificance::getAllNamesAsArray(),
                            'options' => [
                                'placeholder' => 'Стат. значимость',
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
                    <div class="col-xs-6 col-md-1" style="padding-right: 0;">
                        <?= \yii\bootstrap\Html::activeInput('text', $generalLifespanExperiment, '[' . $generalLifespanExperiment->id . ']lifespan_mean_change', ['class' => 'form-control age_unit', 'placeholder' => 'Средн.']) ?>
                    </div>
                    <div class="col-xs-6 col-md-2" style="padding-left: 0;">
                        <?= \kartik\select2\Select2::widget([
                            'model' => $generalLifespanExperiment,
                            'attribute' => '[' . $generalLifespanExperiment->id . ']lifespan_mean_change_stat_sign_id',
                            'data' => \app\models\StatisticalSignificance::getAllNamesAsArray(),
                            'options' => [
                                'placeholder' => 'Стат. значимость',
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
                    <div class="col-xs-6 col-md-1" style="padding-right: 0;">
                        <?= \yii\bootstrap\Html::activeInput('text', $generalLifespanExperiment, '[' . $generalLifespanExperiment->id . ']lifespan_median_change', ['class' => 'form-control age_unit', 'placeholder' => 'Мед.']) ?>
                    </div>
                    <div class="col-xs-6 col-md-2" style="padding-left: 0;">
                        <?= \kartik\select2\Select2::widget([
                            'model' => $generalLifespanExperiment,
                            'attribute' => '[' . $generalLifespanExperiment->id . ']lifespan_median_change_stat_sign_id',
                            'data' => \app\models\StatisticalSignificance::getAllNamesAsArray(),
                            'options' => [
                                'placeholder' => 'Стат. значимость',
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
                    <div class="col-xs-6 col-md-1" style="padding-right: 0;">
                        <?= \yii\bootstrap\Html::activeInput('text', $generalLifespanExperiment, '[' . $generalLifespanExperiment->id . ']lifespan_max_change', ['class' => 'form-control age_unit', 'placeholder' => 'Макс.']) ?>
                    </div>
                    <div class="col-xs-6 col-md-2" style="padding-left: 0;">
                        <?= \kartik\select2\Select2::widget([
                            'model' => $generalLifespanExperiment,
                            'attribute' => '[' . $generalLifespanExperiment->id . ']lifespan_max_change_stat_sign_id',
                            'data' => \app\models\StatisticalSignificance::getAllNamesAsArray(),
                            'options' => [
                                'placeholder' => 'Стат. значимость',
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

            <?php if(Yii::$app->user->can('admin')): ?>
                <div class="col-xs-12">
                    <div class="row form-row">
                        <div class="col-xs-6 col-sm-2">
                            <?= \yii\bootstrap\Html::activeInput('text', $generalLifespanExperiment, '[' . $generalLifespanExperiment->id . ']age', ['class' => 'form-control form_age', 'placeholder' => 'Возраст']) ?>
                        </div>
                        <div class="col-xs-6 col-sm-4">
                            <?= \kartik\select2\Select2::widget([
                                'model' => $generalLifespanExperiment,
                                'attribute' => '[' . $generalLifespanExperiment->id . ']age_unit_id',
                                'data' => \app\models\TimeUnit::getAllNamesAsArray(),
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
                            <?= \yii\bootstrap\Html::activeInput('text', $generalLifespanExperiment, '[' . $generalLifespanExperiment->id . ']lifespan_change_percent_male', ['class' => 'form-control', 'placeholder' => 'Изменение (%) муж']) ?>
                        </div>
                        <div class="col-sm-2">
                            <?= \yii\bootstrap\Html::activeInput('text', $generalLifespanExperiment, '[' . $generalLifespanExperiment->id . ']lifespan_change_percent_female', ['class' => 'form-control', 'placeholder' => 'Изменение (%) жен']) ?>
                        </div>
                        <div class="col-sm-2">
                            <?= \yii\bootstrap\Html::activeInput('text', $generalLifespanExperiment, '[' . $generalLifespanExperiment->id . ']lifespan_change_percent_common', ['class' => 'form-control', 'placeholder' => 'Изменение (%) общее']) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row form-row meta-section">
            <div class="col-xs-6">
                <?= \kartik\select2\Select2::widget([
                    'model' => $generalLifespanExperiment,
                    'attribute' => '[' . $generalLifespanExperiment->id . ']improveVitalProcessIds',
                    'data' => \app\models\VitalProcess::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Улучшает',
                        'multiple' => true,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'tags' => Yii::$app->user->can('admin'),
                        'tokenSeparators' => ['##'],
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-6">
                <?= \kartik\select2\Select2::widget([
                    'model' => $generalLifespanExperiment,
                    'attribute' => '[' . $generalLifespanExperiment->id . ']deteriorVitalProcessIds',
                    'data' => \app\models\VitalProcess::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Ухудшает',
                        'multiple' => true,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'tags' => Yii::$app->user->can('admin'),
                        'tokenSeparators' => ['##'],
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-12 col-sm-6">
                <?= \yii\bootstrap\Html::activeInput('text', $generalLifespanExperiment, '[' . $generalLifespanExperiment->id . ']reference', ['class' => 'form-control', 'placeholder' => 'DOI (пример: 10.1111/acel.12216)']) ?>
            </div>
            <div class="col-xs-12 col-sm-6">
                <?= \yii\bootstrap\Html::activeInput('text', $generalLifespanExperiment, '[' . $generalLifespanExperiment->id . ']pmid', ['class' => 'form-control', 'placeholder' => 'PMID (пример: 34225353)']) ?>
            </div>
        </div>
        <div class="row form-row meta-section">
            <div class="col-xs-12 col-sm-6">
                <?= \yii\bootstrap\Html::activeTextarea($generalLifespanExperiment, '[' . $generalLifespanExperiment->id . ']comment_ru', ['class' => 'form-control', 'placeholder' => 'Дополнительная информация']) ?>
            </div>
            <div class="col-xs-12 col-sm-6">
                <?= \yii\bootstrap\Html::activeTextarea($generalLifespanExperiment, '[' . $generalLifespanExperiment->id . ']comment_en', ['class' => 'form-control', 'placeholder' => 'Дополнительная информация EN']) ?>
            </div>
        </div>
    </div>
    <div class="row form-row">
        <div class="col-xs-12 delete-protein"><?= \yii\bootstrap\Html::activeCheckbox($generalLifespanExperiment, '[' . $generalLifespanExperiment->id . ']delete', ['class' => 'js-delete']) ?></div>
    </div>
</div>
