<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model cms\models\User */
/* @var $form yii\widgets\ActiveForm */

$model->roles = $model->getRolesArray();

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')->dropDownList([
            \cms\models\User::STATUS_ACTIVE => 'активный',
            \cms\models\User::STATUS_INACTIVE => 'неактивный',
            \cms\models\User::STATUS_DELETED => 'удален',
    ]) ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'newPassword')->textInput() ?>
    <label>Роль</label>
    <?= \kartik\select2\Select2::widget([
        'model' => $model,
        'attribute' => 'roles',
        'data' => \cms\models\User::getAllRolesArray(),
        'options' => [
            'placeholder' => 'Роли',
            'multiple' => true
        ],
        'pluginOptions' => [
            'allowClear' => false,
            'tags' => true,
            'tokenSeparators' => [','],
        ],
    ]);
    ?>
    <br>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
