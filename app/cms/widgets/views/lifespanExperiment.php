<?php
/** @var $lifespanExperiment \cms\models\LifespanExperiment */
?>
<div class="form-split protein-activity js-lifespan-experiment">
    <div class="js-lifespan-experiment-block">
        <div class="form-split">
            <div class="form-third">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']gene_intervention_id',
                    'data' => \cms\models\GeneIntervention::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Вмешательство',
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
            <div class="form-third">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']intervention_result_id',
                    'data' => \cms\models\InterventionResult::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Объект',
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
            <div class="form-third">
                <?= \kartik\select2\Select2::widget([
                    'model' => $lifespanExperiment,
                    'attribute' => '[' . $lifespanExperiment->id . ']model_organism_id',
                    'data' => \cms\models\ModelOrganism::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Организм',
                        'multiple' => false
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
        <div class="form-split">
            <?= \yii\bootstrap\Html::activeInput('text', $lifespanExperiment, '[' . $lifespanExperiment->id . ']reference', ['class' => 'form-control', 'placeholder' => 'Ссылка']) ?>
        </div>
        <div class="form-split">
            <div class="form-half-small-margin">
                <?= \yii\bootstrap\Html::activeTextarea($lifespanExperiment, '[' . $lifespanExperiment->id . ']comment_ru', ['class' => 'form-control', 'placeholder' => 'Комментарий']) ?>
            </div>
            <div class="form-half-small-margin">
                <?= \yii\bootstrap\Html::activeTextarea($lifespanExperiment, '[' . $lifespanExperiment->id . ']comment_en', ['class' => 'form-control', 'placeholder' => 'Комментарий EN']) ?>
            </div>
        </div>
    </div>
    <div class="delete-protein"><?= \yii\bootstrap\Html::activeCheckbox($lifespanExperiment, '[' . $lifespanExperiment->id . ']delete', ['class' => 'js-delete']) ?></div>
</div>