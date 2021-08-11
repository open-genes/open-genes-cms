<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Disease */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="disease-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'omim_id')->textInput() ?>

    <?= $form->field($model, 'name_ru')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'icd_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent_icd_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'icd_name_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'icd_name_ru')->textInput(['maxlength' => true]) ?>

    <?=\kartik\select2\Select2::widget([
        'model' => $model,
        'attribute' => 'icd_code_visible',
        'data' => $model->getIcdParentCategories(),
        'options' => [
            'placeholder' => 'Видимый код МКБ (для группировки и API)',
            'multiple' => false
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]);
    ?>
    <br>
    Категории МКБ:
    <ul>
        <?php
        foreach ($model->getIcdParentCategories() as $categoryName) {
            echo "<li> {$categoryName}</li>";
        }
        ?>
    </ul>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
