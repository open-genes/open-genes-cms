<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="page gene-page">
    <div class="page__inner">
        <section>
            <h2><?= Html::encode($this->title) ?></h2>

            <p>Please fill out the following fields to login:</p>

            <div class="row">
                <div class="col-lg-5">
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <?= $form->field($model, 'rememberMe')->checkbox() ?>

                    <div class="form-group">
                        <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </section>
    </div>
</div>