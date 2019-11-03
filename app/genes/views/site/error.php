<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */


$this->title = $name;
?>
<div class="page page--dummy">
    <div class="page__inner">
        <section class="wrapper">
            <div class="container __flex">
                <section class="col col-16 no-content">
                    <div class="no-content__icon no-content__icon-404"></div>
                    <div class="no-content__title">
                        <div class="title__center">
                            <?= Yii::t('main', 'error_page_404') ?>
                        </div>
                    </div>
                </section>
            </div>
        </section>
    </div>
</div>
