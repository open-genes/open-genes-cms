<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Gene */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gene-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'symbol')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'aliases')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'agePhylo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ageMya')->textInput() ?>

    <?= $form->field($model, 'entrezGene')->textInput() ?>

    <?= $form->field($model, 'uniprot')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'why')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'band')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'locationStart')->textInput() ?>

    <?= $form->field($model, 'locationEnd')->textInput() ?>

    <?= $form->field($model, 'orientation')->textInput() ?>

    <?= $form->field($model, 'accPromoter')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accOrf')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accCds')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'references')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'orthologs')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'commentEvolution')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'commentFunction')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'commentCause')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'commentAging')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'commentEvolutionEN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'commentFunctionEN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'commentAgingEN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'commentsReferenceLinks')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rating')->textInput() ?>

    <?= $form->field($model, 'functionalClusters')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isHidden')->checkbox() ?>

    <?= $form->field($model, 'expression')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'expressionEN')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
