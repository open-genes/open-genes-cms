<?php
/** @var $lifespanExperiment \app\models\LifespanExperiment */
?>
<div class="protein-activity js-lifespan-experiment js-gene-link-section">
    <div class="js-lifespan-experiment-block js-gene-link-block">
        <div class="row form-row">
            <div class="col-xs-6 col-md-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']gene_intervention_id',
                    'data' => \app\models\GeneIntervention::getAllNamesAsArray(),
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
            <div class="col-xs-6 col-md-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']model_organism_id',
                    'data' => \app\models\ModelOrganism::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Объект',
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
        </div>

        <div class="row form-row">
            <div class="col-xs-6 col-sm-4">
                <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']age', ['class' => 'form-control form_age', 'placeholder' => 'Возраст']) ?>
            </div>
            <div class="col-xs-6 col-sm-4">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']age_unit',
                    'data' => [1 => 'дней', 4 => 'недель', 2 => 'месяцев', 3 => 'лет'],
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
                <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']lifespan_change_percent_female', ['class' => 'form-control', 'placeholder' => 'Изменение (%) жен']) ?>
            </div>
            <div class="col-xs-6 col-md-3">
                <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']lifespan_change_percent_common', ['class' => 'form-control', 'placeholder' => 'Изменение (%) общее']) ?>
            </div>
            <div class="col-xs-6 col-md-3">
                <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']reference', ['class' => 'form-control', 'placeholder' => 'DOI (пример: 10.1111/acel.12216)']) ?>
            </div>
            <div class="col-xs-6 col-md-3">
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

    <div class="row form-row">
        <div class="col-xs-12 delete-protein"><?= \yii\bootstrap\Html::activeCheckbox($lifespanExperiment, '[' . $lifespanExperiment->id . ']delete', ['class' => 'js-delete']) ?></div>
    </div>
</div>