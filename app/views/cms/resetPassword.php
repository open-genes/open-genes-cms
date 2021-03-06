<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\common\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Сброс пароля';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page gene-page">
    <div class="page__inner">
        <section class="login-form">
            <h2><?= Html::encode($this->title) ?></h2>
            <?=Yii::$app->session->getFlash('request_pass', null, true); ?>

            <p>Пожалуйста, введите Ваш новый пароль:</p>
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

            <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </section>
    </div>
</div>
