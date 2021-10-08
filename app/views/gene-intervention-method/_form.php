<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GeneInterventionMethod */
/* @var $form yii\widgets\ActiveForm */
/* @var $interventionWays array */
?>

<div class="gene-intervention-method-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name_ru')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gene_intervention_way_id')->widget(\kartik\select2\Select2::class, [
        'data' => $interventionWays,
        'options' => ['multiple' => false],
        'pluginOptions' => [
            'allowClear' => false
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>