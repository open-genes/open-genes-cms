<?php

use app\widgets\GeneProteinActivity;
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

$this->registerJsFile('/assets/js/gene.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('/assets/css/gene.css');

?>

<div class="gene-form">
    <?php $form = ActiveForm::begin(); ?>
    <?php if(Yii::$app->user->can('editor')): ?>
    <?= $form->field($model, 'isHidden')->checkbox() ?>
    <?php endif; ?>
    Источник: <?=$model->source ?? 'нет' ?>

    <?php if(Yii::$app->user->can('admin')): // todo add more operations to auth manager ?>
    <div class="row form-row">
        <div class="col-xs-6 col-sm-3">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-6 col-sm-3">
            <?= $form->field($model, 'symbol')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-6 col-sm-3">
            <?= $form->field($model, 'ncbi_id')->textInput() ?>
        </div>
        <div class="col-xs-6 col-sm-3">
            <?= $form->field($model, 'uniprot')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'aliases')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <?php endif ?>

    <div class="row form-row">
        <div class="col-xs-12 col-sm-3">
            <?= $form->field($model, 'phylum_id')->dropDownList(['' => null] + $allAges) ?>
        </div>
        <div class="col-xs-12 col-sm-3">
            <?= $form->field($model, 'family_phylum_id')->dropDownList(['' => null] + $allAges) ?>
        </div>
        <div class="col-xs-12 col-sm-3">
            <?= $form->field($model, 'expressionChange')->dropDownList([
                '0' => '',
                '1' => 'уменьшается',
                '2' => 'увеличивается',
                '3' => 'неоднозначно',
            ]) ?>
        </div>
        <div class="col-xs-12 col-sm-6">
            <?= $form->field($model, 'functionalClustersIdsArray')->widget(\kartik\select2\Select2::class, [
                'data' => $allFunctionalClusters,
                'options' => ['multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
    </div>

    <div class="row form-row">
        <div class="col-xs-12 col-sm-12">
            <?= $form->field($model, 'commentCauseIdsArray')->widget(\kartik\select2\Select2::class, [
                'data' => $allCommentCauses,
                'options' => ['multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
    </div>

    <?php if(Yii::$app->user->can('editor')): // todo add more operations to auth manager ?>
    <div class="row form-row">
        <div class="col-xs-12">
            <?= $form->field($model, 'diseasesIdsArray')->widget(\kartik\select2\Select2::class, [
                'data' => $allDiseases,
                'options' => ['multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'ncbi_summary_ru')->textarea(['rows' => 4]) ?>
            <?= $form->field($model, 'ncbi_summary_en')->textarea(['rows' => 4]) ?>
            <?= $form->field($model, 'og_summary_ru')->textarea(['rows' => 4]) ?>
            <?= $form->field($model, 'og_summary_en')->textarea(['rows' => 4]) ?>
            <?= $form->field($model, 'uniprot_summary_ru')->textarea(['rows' => 4]) ?>
            <?= $form->field($model, 'uniprot_summary_en')->textarea(['rows' => 4]) ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="row form-row">
        <div class="col-xs-12">
            <?= $form->field($model, 'commentEvolution')->textarea(['rows' => 4]) ?>
            <?= $form->field($model, 'commentEvolutionEN')->textarea(['rows' => 4]) ?>
        </div>
    </div>

    <?php if(Yii::$app->user->can('admin')): // todo add more operations to auth manager ?>
    <div class="row form-row">
        <div class="col-xs-6 col-sm-3">
            <?= $form->field($model, 'orientation')->dropDownList([-1 => -1, 0 => 0, 1 => 1]) ?>
        </div>
        <div class="col-xs-6 col-sm-3">
            <?= $form->field($model, 'accPromoter')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-6 col-sm-3">
            <?= $form->field($model, 'band')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-6 col-sm-3">
            <?= $form->field($model, 'why')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-6 col-sm-3">
            <?= $form->field($model, 'accOrf')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-6 col-sm-3">
            <?= $form->field($model, 'locationStart')->textInput() ?>
        </div>
        <div class="col-xs-6 col-sm-3">
            <?= $form->field($model, 'accCds')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-6 col-sm-3">
            <?= $form->field($model, 'locationEnd')->textInput() ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'orthologs')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row form-row">
        <div class="col-sm-12">
            <?= $form->field($model, 'references')->textarea(['maxlength' => true]) ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="row form-row">
        <div class="col-xs-12">
        <?= $form->field($model, 'protein_complex_ru')->textarea(['rows' => 4]) ?>
        </div>
        <div class="col-xs-12">
        <?= $form->field($model, 'protein_complex_en')->textarea(['rows' => 4]) ?>
        </div>
    </div>

    <?php if(Yii::$app->user->can('editor')): ?>
    <div class="row form-row">
        <div class="col-xs-12">
        <?= $form->field($model, 'proteinClassesIdsArray')->widget(\kartik\select2\Select2::class, [
            'data' => $allProteinClasses,
            'options' => ['multiple' => true],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="row form-row">
        <div class="col-xs-12">
            <?= $form->field($model, 'commentsReferenceLinks')->textarea(['rows' => 4]) ?>
        </div>
    </div>

    <div class="submit-panel">
        <div class="container">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
