<?php
/** @var $ageRelatedChange \app\models\AgeRelatedChange */
?>
<div class="protein-activity blue js-age-related-change js-gene-link-section">
    <div class="js-age-related-change-block js-gene-link-block">
        <div class="row form-row">
            <div class="col-xs-6">
                <?= \kartik\select2\Select2::widget([
                    'model' => $ageRelatedChange,
                    'attribute' => '[' . $ageRelatedChange->id . ']age_related_change_type_id',
                    'data' => \app\models\AgeRelatedChangeType::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Вид изменений',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'tags' => Yii::$app->user->can('admin'),
                        'tokenSeparators' => ['##'],
                        'containerCssClass' => 'blue',
                        'dropdownCssClass' => 'blue',
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-6">
                <?= \kartik\select2\Select2::widget([
                    'model' => $ageRelatedChange,
                    'attribute' => '[' . $ageRelatedChange->id . ']model_organism_id',
                    'data' => \app\models\ModelOrganism::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Объект',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'tags' => true,
                        'tokenSeparators' => ['##'],
                        'containerCssClass' => 'blue',
                        'dropdownCssClass' => 'blue',
                    ],
                ]);
                ?>
            </div>
        </div>
        <div class="row form-row">
            <div class="col-xs-4">
                <?= \kartik\select2\Select2::widget([
                    'model' => $ageRelatedChange,
                    'attribute' => '[' . $ageRelatedChange->id . ']organism_line_id',
                    'data' => \app\models\OrganismLine::getAllNamesByOrganisms(),
                    'options' => [
                        'placeholder' => 'Линия',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'tags' => true,
                        'tokenSeparators' => ['##'],
                        'containerCssClass' => 'blue',
                        'dropdownCssClass' => 'blue',
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-4">
                <?= \kartik\select2\Select2::widget([
                    'model' => $ageRelatedChange,
                    'attribute' => '[' . $ageRelatedChange->id . ']sample_id',
                    'data' => \app\models\Sample::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Образец',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'tags' => true,
                        'tokenSeparators' => ['##'],
                        'containerCssClass' => 'blue',
                        'dropdownCssClass' => 'blue',
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-4">
                <?= \kartik\select2\Select2::widget([
                    'model' => $ageRelatedChange,
                    'attribute' => '[' . $ageRelatedChange->id . ']sex',
                    'data' => \app\models\OrganismSex::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'пол',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'tags' => true,
                        'tokenSeparators' => ['##'],
                        'containerCssClass' => 'blue',
                        'dropdownCssClass' => 'blue',
                    ],
                ]);
                ?>
            </div>
        </div>
        <div class="row form-row">
            <div class="col-xs-3 col-sm-3">
                <?= \yii\bootstrap\Html::activeInput('text', $ageRelatedChange, '[' . $ageRelatedChange->id . ']n_of_controls', ['class' => 'form-control form_age', 'placeholder' => 'N контроля']) ?>
            </div>
            <div class="col-xs-3 col-sm-3">
                <?= \yii\bootstrap\Html::activeInput('text', $ageRelatedChange, '[' . $ageRelatedChange->id . ']mean_age_of_controls', ['class' => 'form-control form_age', 'placeholder' => 'Средний возраст контроля']) ?>
            </div>
            <div class="col-xs-3 col-sm-3">
                <?= \yii\bootstrap\Html::activeInput('text', $ageRelatedChange, '[' . $ageRelatedChange->id . ']min_age_of_controls', ['class' => 'form-control form_age', 'placeholder' => 'мин. возраст контроля']) ?>
            </div>
            <div class="col-xs-3 col-sm-3">
                <?= \yii\bootstrap\Html::activeInput('text', $ageRelatedChange, '[' . $ageRelatedChange->id . ']max_age_of_controls', ['class' => 'form-control form_age', 'placeholder' => 'мин. возраст контроля']) ?>
            </div>
        </div>
        <div class="row form-row">
            <div class="col-xs-3 col-sm-3">
                <?= \yii\bootstrap\Html::activeInput('text', $ageRelatedChange, '[' . $ageRelatedChange->id . ']n_of_experiment', ['class' => 'form-control form_age', 'placeholder' => 'N эксперимента']) ?>
            </div>
            <div class="col-xs-3 col-sm-3">
                <?= \yii\bootstrap\Html::activeInput('text', $ageRelatedChange, '[' . $ageRelatedChange->id . ']mean_age_of_experiment', ['class' => 'form-control form_age', 'placeholder' => 'Средний возраст эксперимента']) ?>
            </div>
            <div class="col-xs-3 col-sm-3">
                <?= \yii\bootstrap\Html::activeInput('text', $ageRelatedChange, '[' . $ageRelatedChange->id . ']min_age_of_experiment', ['class' => 'form-control form_age', 'placeholder' => 'мин. возраст эксперимента']) ?>
            </div>
            <div class="col-xs-3 col-sm-3">
                <?= \yii\bootstrap\Html::activeInput('text', $ageRelatedChange, '[' . $ageRelatedChange->id . ']max_age_of_experiment', ['class' => 'form-control form_age', 'placeholder' => 'мин. возраст эксперимента']) ?>
            </div>
        </div>
        <div class="row form-row">
            <div class="col-xs-3 col-sm-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $ageRelatedChange,
                    'attribute' => '[' . $ageRelatedChange->id . ']age_unit_id',
                    'data' => \app\models\TimeUnit::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Ед. изм. возраста',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'containerCssClass' => 'blue form_age_unit',
                        'dropdownCssClass' => 'blue',
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-3 col-sm-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $ageRelatedChange,
                    'attribute' => '[' . $ageRelatedChange->id . ']statistical_method_id',
                    'data' => \app\models\StatisticalMethod::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Статистический анализ',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'containerCssClass' => 'blue form_age_unit',
                        'dropdownCssClass' => 'blue',
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-3 col-sm-3">
                <?= \yii\bootstrap\Html::activeInput('text', $ageRelatedChange, '[' . $ageRelatedChange->id . ']change_value', ['class' => 'form-control', 'placeholder' => 'Изменение (%)']) ?>
            </div>
            <div class="col-xs-3 col-sm-3">
                <?= \yii\bootstrap\Html::activeInput('text', $ageRelatedChange, '[' . $ageRelatedChange->id . ']p_value', ['class' => 'form-control', 'placeholder' => 'p-value']) ?>
            </div>
        </div>

        <div class="row form-row">
            <div class="col-xs-3 col-sm-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $ageRelatedChange,
                    'attribute' => '[' . $ageRelatedChange->id . ']expression_evaluation_by_id',
                    'data' => \app\models\ExpressionEvaluation::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Оценка экспрессии по',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'containerCssClass' => 'blue',
                        'dropdownCssClass' => 'blue',
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-3 col-sm-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $ageRelatedChange,
                    'attribute' => '[' . $ageRelatedChange->id . ']measurement_type_id',
                    'data' => \app\models\MeasurementType::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Mетод измерения',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'containerCssClass' => 'blue',
                        'dropdownCssClass' => 'blue',
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-3 col-sm-3">
                <?= \yii\bootstrap\Html::activeInput('text', $ageRelatedChange, '[' . $ageRelatedChange->id . ']reference', ['class' => 'form-control', 'placeholder' => 'DOI (пример: 10.1111/acel.12216)']) ?>
            </div>
            <div class="col-xs-3 col-sm-3">
                <?= \yii\bootstrap\Html::activeInput('text', $ageRelatedChange, '[' . $ageRelatedChange->id . ']pmid', ['class' => 'form-control', 'placeholder' => 'PMID (пример: 34225353)']) ?>
            </div>
        </div>

        <div class="row form-row">
            <div class="col-xs-12 col-sm-6">
                <?= \yii\bootstrap\Html::activeTextarea($ageRelatedChange, '[' . $ageRelatedChange->id . ']comment_ru', ['class' => 'form-control', 'placeholder' => 'Дополнительная информация']) ?>
            </div>
            <div class="col-xs-12 col-sm-6">
                <?= \yii\bootstrap\Html::activeTextarea($ageRelatedChange, '[' . $ageRelatedChange->id . ']comment_en', ['class' => 'form-control', 'placeholder' => 'Дополнительная информация EN']) ?>
            </div>
        </div>
    </div>
    <div class="row form-row">
        <div class="col-xs-12 delete-protein"><?= \yii\bootstrap\Html::activeCheckbox($ageRelatedChange, '[' . $ageRelatedChange->id . ']delete', ['class' => 'js-delete']) ?></div>
    </div>
</div>