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

    <div class="form-group field-disease-icd_code_visible">
        <label class="control-label" for="disease-icd_code_visible"><?=Yii::t('common', 'ICD code visible')?></label>
        <?= \kartik\select2\Select2::widget([
            'model' => $model,
            'attribute' => 'icd_code_visible',
            'data' => $model->getIcdParentCategories(),
            'options' => [
                'placeholder' => Yii::t('common', 'ICD code visible'),
                'multiple' => false
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]);
        ?>
        <div class="help-block"></div>
    </div>
    <br>
    <?=Yii::t('common', 'ICD category') . ':'?>
    <ul>
        <?php
        foreach ($model->getIcdParentCategories() as $categoryName) {
            echo "<li> {$categoryName}</li>";
        }
        ?>
    </ul>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
