<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */


$this->title = 'Произошла ошибка :(';
?>
<div class="page gene-page">
    <div class="page__inner">
        <section class="error">
            <h3><?= \yii\helpers\Html::encode($this->title) ?></h3>

            <p><?= $exception->getMessage() ?></p>
            <p>Пожалуйста, обратитесь к администратору, если Вам нужна помощь.</p>

        </section>
    </div>
</div>
