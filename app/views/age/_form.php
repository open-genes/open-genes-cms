<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model cms\models\Phylum */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="age-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name_phylo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_mya')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
