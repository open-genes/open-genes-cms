<?php
/** @var $ageRelatedChange \cms\models\AgeRelatedChange */
?>
<div class="form-split protein-activity js-age-related-change js-gene-link-section">
    <div class="js-age-related-change-block js-gene-link-block">
        <div class="form-split">
            <div class="form-half-without-margin">
                <div class="form-half-without-margin">
                    <?= \kartik\select2\Select2::widget([
                        'model' => $ageRelatedChange,
                        'attribute' => '[' . $ageRelatedChange->id . ']age_related_change_type_id',
                        'data' => \cms\models\AgeRelatedChangeType::getAllNamesAsArray(),
                        'options' => [
                            'placeholder' => 'Вид изменений',
                            'multiple' => false
                        ],
                        'pluginOptions' => [
                            'allowClear' => false,
                            'tags' => true,
                            'tokenSeparators' => [','],
                        ],
                    ]);
                    ?>
                </div>
                <div class="form-half-without-margin">
                    <?= \kartik\select2\Select2::widget([
                        'model' => $ageRelatedChange,
                        'attribute' => '[' . $ageRelatedChange->id . ']sample_id',
                        'data' => \cms\models\Sample::getAllNamesAsArray(),
                        'options' => [
                            'placeholder' => 'Образец',
                            'multiple' => false,
                        ],
                        'pluginOptions' => [
                            'allowClear' => false,
                            'tags' => true,
                            'tokenSeparators' => [','],
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-half-without-margin">
                <div class="form-half-without-margin">
                    <?= \kartik\select2\Select2::widget([
                        'model' => $ageRelatedChange,
                        'attribute' => '[' . $ageRelatedChange->id . ']model_organism_id',
                        'data' => \cms\models\ModelOrganism::getAllNamesAsArray(),
                        'options' => [
                            'placeholder' => 'Организм',
                            'multiple' => false
                        ],
                        'pluginOptions' => [
                            'allowClear' => false,
                            'tags' => true,
                            'tokenSeparators' => [','],
                        ],
                    ]);
                    ?>
                </div>
                <div class="form-half-without-margin">
                    <?= \kartik\select2\Select2::widget([
                        'model' => $ageRelatedChange,
                        'attribute' => '[' . $ageRelatedChange->id . ']organism_line_id',
                        'data' => \cms\models\OrganismLine::getAllNamesAsArray(),
                        'options' => [
                            'placeholder' => 'Линия организма',
                            'multiple' => false,
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'tags' => true,
                            'tokenSeparators' => [','],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="form-split">
            <div class="form-half-without-margin">
                <div class="form-third">
                    <?= \yii\bootstrap\Html::activeInput('text', $ageRelatedChange, '[' . $ageRelatedChange->id . ']age_from', ['class' => 'form-control', 'placeholder' => 'Возраст - от']) ?>
                </div>
                <div class="form-third">
                    <?= \yii\bootstrap\Html::activeInput('text', $ageRelatedChange, '[' . $ageRelatedChange->id . ']age_to', ['class' => 'form-control', 'placeholder' => 'Возраст - до']) ?>
                </div>
                <div class="form-third">
                    <?= \kartik\select2\Select2::widget([
                        'model' => $ageRelatedChange,
                        'attribute' => '[' . $ageRelatedChange->id . ']age_unit',
                        'data' => [1 => 'дней', 2 => 'месяцев', 3 => 'лет'],
                        'options' => [
                            'placeholder' => 'Ед. изм. возраста',
                            'multiple' => false
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
                </div>

            </div>
            <div class="form-half-without-margin">
                <div class="form-third">
                    <?= \yii\bootstrap\Html::activeInput('text', $ageRelatedChange, '[' . $ageRelatedChange->id . ']change_value_male', ['class' => 'form-control', 'placeholder' => 'Изменение (%) муж']) ?>
                </div>
                <div class="form-third">
                    <?= \yii\bootstrap\Html::activeInput('text', $ageRelatedChange, '[' . $ageRelatedChange->id . ']change_value_female', ['class' => 'form-control', 'placeholder' => 'Изменение (%) жен']) ?>
                </div>
                <div class="form-third">
                    <?= \yii\bootstrap\Html::activeInput('text', $ageRelatedChange, '[' . $ageRelatedChange->id . ']change_value_common', ['class' => 'form-control', 'placeholder' => 'Изменение (%) общее']) ?>
                </div>
            </div>
        </div>
        <div class="form-split">
            <?= \yii\bootstrap\Html::activeInput('text', $ageRelatedChange, '[' . $ageRelatedChange->id . ']reference', ['class' => 'form-control', 'placeholder' => 'Ссылка']) ?>
        </div>
        <div class="form-split">
            <div class="form-half-small-margin">
                <?= \yii\bootstrap\Html::activeTextarea($ageRelatedChange, '[' . $ageRelatedChange->id . ']comment_ru', ['class' => 'form-control', 'placeholder' => 'Дополнительная информация']) ?>
            </div>
            <div class="form-half-small-margin">
                <?= \yii\bootstrap\Html::activeTextarea($ageRelatedChange, '[' . $ageRelatedChange->id . ']comment_en', ['class' => 'form-control', 'placeholder' => 'Дополнительная информация EN']) ?>
            </div>
        </div>
    </div>
    <div class="delete-protein"><?= \yii\bootstrap\Html::activeCheckbox($ageRelatedChange, '[' . $ageRelatedChange->id . ']delete', ['class' => 'js-delete']) ?></div>
</div>