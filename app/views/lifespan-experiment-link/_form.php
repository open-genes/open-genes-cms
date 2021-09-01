<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LifespanExperimentLink */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lifespan-experiment-link-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lifespan_experiment_from_id')->textInput() ?>

    <?= $form->field($model, 'lifespan_experiment_to_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
