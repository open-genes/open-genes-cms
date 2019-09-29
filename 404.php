<? include $_SERVER['DOCUMENT_ROOT'] . '/contollers/core.php'; ?>

<?
include $_SERVER['DOCUMENT_ROOT'] . '/view/chunks/head.inc.php';
html_headChunk('404');
?>

<body class="app-body app-body--gene">

<? include $_SERVER['DOCUMENT_ROOT'] . '/view/chunks/loader.inc.php'; ?>

<? include $_SERVER['DOCUMENT_ROOT'] . '/view/chunks/header.inc.php'; ?>

<div class="page page--dummy">
    <div class="page__inner">
        <section class="wrapper">
            <div class="container __flex">
                <section class="col col-16 no-content">
                    <div class="no-content__icon no-content__icon-404"></div>
                    <div class="no-content__title">
                        <div class="title__center">
                            <?= $translation->translate('error_page_404') ?>
                        </div>
                    </div>
                </section>
            </div>
        </section>
    </div>
</div>
