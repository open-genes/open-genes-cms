<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */


$this->title = Yii::t('common', 'Error :(');
?>
<div class="page gene-page">
    <div class="page__inner">
        <section class="error">
            <h3><?= \yii\helpers\Html::encode($this->title) ?></h3>

            <p><?= $exception->getMessage() ?></p>
            <p><?=Yii::t('common', 'Please, contact the administrator if you need help')?></p>

        </section>
    </div>
</div>
