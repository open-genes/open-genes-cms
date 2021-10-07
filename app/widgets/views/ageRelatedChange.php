<?php
/** @var $ageRelatedChange \app\models\AgeRelatedChange */
?>
<div class="protein-activity blue js-age-related-change js-gene-link-section">
    <div class="js-age-related-change-block js-gene-link-block">
        <div class="row form-row">
            <div class="col-xs-3">
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
            <div class="col-xs-3">
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
            <div class="col-xs-3">
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
            <div class="col-xs-3">
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
        </div>
        <div class="row form-row">
            <div class="col-xs-6 col-sm-4">
                <?= \yii\bootstrap\Html::activeInput('text', $ageRelatedChange, '[' . $ageRelatedChange->id . ']age_from', ['class' => 'form-control form_age', 'placeholder' => 'Возраст - от']) ?>
            </div>
            <div class="col-xs-6 col-sm-4">
                <?= \yii\bootstrap\Html::activeInput('text', $ageRelatedChange, '[' . $ageRelatedChange->id . ']age_to', ['class' => 'form-control form_age', 'placeholder' => 'Возраст - до']) ?>
            </div>
            <div class="col-xs-6 col-sm-4">
                <?= \kartik\select2\Select2::widget([
                    'model' => $ageRelatedChange,
                    'attribute' => '[' . $ageRelatedChange->id . ']age_unit',
                    'data' => [1 => 'дней', 4 => 'недель', 2 => 'месяцев', 3 => 'лет'],
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
            <div class="col-xs-6 col-sm-4">
                <?= \yii\bootstrap\Html::activeInput('text', $ageRelatedChange, '[' . $ageRelatedChange->id . ']change_value_male', ['class' => 'form-control', 'placeholder' => 'Изменение (%) муж']) ?>
            </div>
            <div class="col-xs-6 col-sm-4">
                <?= \yii\bootstrap\Html::activeInput('text', $ageRelatedChange, '[' . $ageRelatedChange->id . ']change_value_female', ['class' => 'form-control', 'placeholder' => 'Изменение (%) жен']) ?>
            </div>
            <div class="col-xs-6 col-sm-4">
                <?= \yii\bootstrap\Html::activeInput('text', $ageRelatedChange, '[' . $ageRelatedChange->id . ']change_value_common', ['class' => 'form-control', 'placeholder' => 'Изменение (%) общее']) ?>
            </div>
        </div>

        <div class="row form-row">
            <div class="col-xs-6 col-sm-4">
                <?= \kartik\select2\Select2::widget([
                    'model' => $ageRelatedChange,
                    'attribute' => '[' . $ageRelatedChange->id . ']measurement_type',
                    'data' => [1 => 'мРНК', 2 => 'белок', 3 => 'Количество клеток, экспрессирующих ген'],
                    'options' => [
                        'placeholder' => 'Метод измерения',
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
            <div class="col-xs-6 col-sm-4">
                <?= \yii\bootstrap\Html::activeInput('text', $ageRelatedChange, '[' . $ageRelatedChange->id . ']reference', ['class' => 'form-control', 'placeholder' => 'DOI (пример: 10.1111/acel.12216)']) ?>
            </div>
            <div class="col-xs-6 col-sm-4">
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