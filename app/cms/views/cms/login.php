<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="page gene-page">
    <div class="page__inner">
        <section class="login-form">
            <h2><?= Html::encode($this->title) ?></h2>

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Логин'])->label(false) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль'])->label(false) ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?= Html::a('Восстановить пароль', 'request-password-reset'); ?>
            <?php ActiveForm::end(); ?>
        </section>
    </div>
</div>