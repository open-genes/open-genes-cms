<?php
/** @var $geneInterventionToVitalProcess \app\models\GeneInterventionToVitalProcess */
?>
<div class="form-split protein-activity green js-intervention-to-vital-process js-gene-link-section">
    <div class="js-intervention-to-vital-process-block js-gene-link-block">
        <div class="form-split">
            <div class="form-third">
                <?= \kartik\select2\Select2::widget([
                    'model' => $geneInterventionToVitalProcess,
                    'attribute' => '[' . $geneInterventionToVitalProcess->id . ']gene_intervention_id',
                    'data' => \app\models\GeneIntervention::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Вмешательство',
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
            <div class="form-third">
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
                        'tags' => true,
                        'tokenSeparators' => ['##'],
                        'containerCssClass' => 'green',
                        'dropdownCssClass' => 'green',
                    ],
                ]);
                ?>
            </div>
            <div class="form-third">
                <?= \kartik\select2\Select2::widget([
                    'model' => $geneInterventionToVitalProcess,
                    'attribute' => '[' . $geneInterventionToVitalProcess->id . ']model_organism_id',
                    'data' => \app\models\ModelOrganism::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Организм',
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
        <div class="form-split">
            <div class="form-third">
                <div class="form-half-without-margin">
                    <?= \yii\bootstrap\Html::activeInput('text', $geneInterventionToVitalProcess, '[' . $geneInterventionToVitalProcess->id . ']age', ['class' => 'form-control', 'placeholder' => 'Возраст']) ?>
                </div>
                <div class="form-half-without-margin">
                    <?= \kartik\select2\Select2::widget([
                        'model' => $geneInterventionToVitalProcess,
                        'attribute' => '[' . $geneInterventionToVitalProcess->id . ']age_unit',
                        'data' => [1 => 'дней', 2 => 'месяцев', 3 => 'лет'],
                        'options' => [
                            'placeholder' => 'Ед. изм. возраста',
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
            <div class="form-third">
                <?= \kartik\select2\Select2::widget([
                    'model' => $geneInterventionToVitalProcess,
                    'attribute' => '[' . $geneInterventionToVitalProcess->id . ']organism_line_id',
                    'data' => \app\models\OrganismLine::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Линия организма',
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
            <div class="form-third">
                <div class="form-half-without-margin">
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
                <div class="form-half-without-margin">
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
        </div>
        <div class="form-split">
            <?= \yii\bootstrap\Html::activeInput('text', $geneInterventionToVitalProcess, '[' . $geneInterventionToVitalProcess->id . ']reference', ['class' => 'form-control', 'placeholder' => 'Ссылка']) ?>
        </div>
        <div class="form-split no-margin">
            <div class="form-half-small-margin">
                <?= \yii\bootstrap\Html::activeTextarea($geneInterventionToVitalProcess, '[' . $geneInterventionToVitalProcess->id . ']comment_ru', ['class' => 'form-control', 'placeholder' => 'Дополнительная информация']) ?>
            </div>
            <div class="form-half-small-margin">
                <?= \yii\bootstrap\Html::activeTextarea($geneInterventionToVitalProcess, '[' . $geneInterventionToVitalProcess->id . ']comment_en', ['class' => 'form-control', 'placeholder' => 'Дополнительная информация EN']) ?>
            </div>
        </div>
    </div>
    <div class="delete-protein"><?= \yii\bootstrap\Html::activeCheckbox($geneInterventionToVitalProcess, '[' . $geneInterventionToVitalProcess->id . ']delete', ['class' => 'js-delete']) ?></div>
</div>