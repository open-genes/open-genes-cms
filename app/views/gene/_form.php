<?php

use app\widgets\GeneProteinActivity;
use app\widgets\LifespanExperimentWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Gene */
/* @var $allFunctionalClusters [] */
/* @var $allDiseases [] */
/* @var $allCommentCauses [] */
/* @var $allProteinClasses [] */
/* @var $allAges[] */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile('/assets/js/experiments.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('/assets/css/gene.css');

?>

<div class="gene-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php if(Yii::$app->user->can('editor')): ?>
    <?= $form->field($model, 'isHidden')->checkbox() ?>
    <?php endif; ?>
    <div class="form-split">
        <div class="form-half">
            <div class="form-split">
                <div class="form-half">
                    <?= $form->field($model, 'age_id')->dropDownList($allAges) ?>
                </div>
                <div class="form-half">
                    <?= $form->field($model, 'expressionChange')->dropDownList([
                        '0' => '',
                        '1' => 'уменьшается',
                        '2' => 'увеличивается',
                        '3' => 'неоднозначно',
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="form-half">
            <?= $form->field($model, 'functionalClustersIdsArray')->widget(\kartik\select2\Select2::class, [
                'data' => $allFunctionalClusters,
                'options' => ['multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
    </div>
    <?= $form->field($model, 'commentCauseIdsArray')->widget(\kartik\select2\Select2::class, [
        'data' => $allCommentCauses,
        'options' => ['multiple' => true],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>
    <?php if(Yii::$app->user->can('editor')): // todo add more operations to auth manager ?>
        <div>
            <?= $form->field($model, 'diseasesIdsArray')->widget(\kartik\select2\Select2::class, [
                'data' => $allDiseases,
                'options' => ['multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
        <?= $form->field($model, 'summary_ru')->textarea(['rows' => 4]) ?>
        <?= $form->field($model, 'summary_en')->textarea(['rows' => 4]) ?>
        <?= $form->field($model, 'commentAging')->textarea(['rows' => 4]) ?>
        <?= $form->field($model, 'commentAgingEN')->textarea(['rows' => 4]) ?>
        <?= $form->field($model, 'commentFunction')->textarea(['rows' => 4]) ?>
        <?= $form->field($model, 'commentFunctionEN')->textarea(['rows' => 4]) ?>
    <?php endif; ?>

    <?= $form->field($model, 'commentEvolution')->textarea(['rows' => 4]) ?>
    <?= $form->field($model, 'commentEvolutionEN')->textarea(['rows' => 4]) ?>
    <?= $form->field($model, 'commentsReferenceLinks')->textarea(['rows' => 4]) ?>

    <?php if(Yii::$app->user->can('admin')): // todo add more operations to auth manager ?>

    <div class="form-split">
        <div class="form-half">
            <div class="form-split">
                <div class="form-half">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'orientation')->dropDownList([-1 => -1, 0 => 0, 1 => 1]) ?>
                    <?= $form->field($model, 'ncbi_id')->textInput() ?>
                    <?= $form->field($model, 'uniprot')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="form-half">
                    <?= $form->field($model, 'symbol')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'accPromoter')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'band')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'why')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="form-half">
            <?= $form->field($model, 'aliases')->textInput(['maxlength' => true]) ?>
            <div class="form-split">
                <div class="form-half">
                    <?= $form->field($model, 'accOrf')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'locationStart')->textInput() ?>
                </div>
                <div class="form-half">
                    <?= $form->field($model, 'accCds')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'locationEnd')->textInput() ?>
                </div>
            </div>
            <?= $form->field($model, 'references')->textInput(['maxlength' => true]) ?>
        </div>
        <?= $form->field($model, 'orthologs')->textInput(['maxlength' => true]) ?>
    </div>
    <?php endif; ?>
    <?= $form->field($model, 'protein_complex_ru')->textarea(['rows' => 4]) ?>
    <?= $form->field($model, 'protein_complex_en')->textarea(['rows' => 4]) ?>

    <?php if(Yii::$app->user->can('editor')): ?>
        <?= $form->field($model, 'proteinClassesIdsArray')->widget(\kartik\select2\Select2::class, [
            'data' => $allProteinClasses,
            'options' => ['multiple' => true],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
    <?php endif; ?>
    <br>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
