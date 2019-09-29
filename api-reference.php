<? include $_SERVER['DOCUMENT_ROOT'] . '/contollers/core.php'; ?>
<!DOCTYPE html >
<html>
<?
include $_SERVER['DOCUMENT_ROOT'] . '/view/chunks/head.inc.php';
html_headChunk('Aging Related Genes Base');
?>

<body>

<? include $_SERVER['DOCUMENT_ROOT'] . '/view/chunks/loader.inc.php'; ?>

<? include $_SERVER['DOCUMENT_ROOT'] . '/view/chunks/header.inc.php'; ?>

<div class="page about-page">
    <div class="page__inner">
        <div class="wrapper main-page__header">
            <div class="container">
                <div class="col col-16">
                    <div class="page__title">
                        <h1><?= $translation->translate('api-page_title') ?></h1>
                    </div>
                    <div class="header__description">
                        <?= $translation->translate('api-page_description') ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <section class="col col-16 no-content">
                <div class="no-content__icon no-content__icon-standard"></div>
                <div class="no-content__title">
                    <div class="title__center">
                        Этот раздел скоро дополнится.
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<? include $_SERVER['DOCUMENT_ROOT'] . '/footer.inc.php'; ?>

</body>
</html>