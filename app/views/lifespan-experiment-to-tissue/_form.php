<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LifespanExperimentToTissue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lifespan-experiment-to-tissue-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lifespan_experiment_id')->textInput() ?>

    <?= $form->field($model, 'tissue_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
