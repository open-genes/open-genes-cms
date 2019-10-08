<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use genes\assets\OpenGenesAsset;
use common\widgets\Alert;

OpenGenesAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<?php // todo $this->head() etc
$randomVersion = rand(10, 9999);
?>

<head>
  <?php
  $this->head()
  ?>
  <meta charset = 'utf-8'>
  <title><?= Html::encode($this->title) ?></title >
  <meta name='description' content=''>
  <meta name = 'viewport' content = 'width=device-width, initial-scale=1, maximum-scale=1'>
  <meta property='og:image' content='/images/social-cover.png'>
</head>

<div class="loader" id="js_loader">
    <div class="loader__inner">
        <span class="spinner"></span>
        <div class="loader__description" id="js_loader-text"><?= Yii::t('main', 'ui_loader'); ?></div>
    </div>
</div>
<header class="header">
    <a class="header__logo"
       href="/"
       title="<?= Yii::t('main', 'main_page_link'); ?>">
    </a>


    <? if (Yii::$app->user->isGuest): ?>
    <div class="header__signin">
        <button
                value="EN"
                class="language-switcher js_language-switcher">
            RU
        </button>

        <div class="signin__button js_signin-btn">
            <span class="fa far fa-bars"></span>
        </div>

        <div class="header__menu js_header-menu hidden">
            <div class="menu__panel">
                <form method="post" action="/auth">
                    <div class="ui-row ui-row--v">
                        <input type="text"
                               name="user"
                               placeholder="<?= Yii::t('main', 'header_menu_username'); ?>"
                               class="field"
                        >
                        <input type="password"
                               name="password"
                               placeholder="<?= Yii::t('main', 'header_menu_password'); ?>"
                               class="field"
                        >
                    </div>
                    <div class="ui-row ui-row--v">
                        <button type="submit"
                                value="submit"
                                class="btn btn-fill btn--big btn-purple"
                        >
                            <?= Yii::t('main', 'header_menu_sign_in'); ?>
                        </button>
                        <input type="reset"
                               name="reset"
                               value="clear"
                               class="hidden"
                        >
                    </div>
                </form>

                <ul class="menu__links">
                    <?php
                    // todo yii\widgets\Menu
                    $menuLinks = array (
                        1  => array(
                            'URL' => 'about',
                            'title' => 'header_menu_about'
                        ),

                        2  => array(
                            'URL' => 'api-reference',
                            'title' => 'header_menu_api'
                        )

                    ) ?>
                    <? foreach($menuLinks as $menuLink): ?>
                        <li class="menu__link">
                            <a href="/<?= $menuLink['URL'] ?>"
                               class="js_nav_link"
                            >
                                <?= $menuLink['title'] ?>
                            </a>
                        </li>
                    <? endforeach; ?>
                </ul>
            </div>
        </div>

        <? else: ?>
            <form class="header__signin"
                  method="post"
                  action="/manage?logout=1"
            >
                <button class="signin__button icon-btn" type="submit">
                    <span class="fa far fa-sign-out"></span>
                </button>
            </form>
        <? endif; ?>
</header>
<body>
<?php $this->beginBody() ?>

<?= Alert::widget() ?>
<?= $content ?>

<footer class="wrapper footer">
    <div class="container">
        <div class="per per-70">
            <a href="/export"
               class="link"
               target="_blank"
            ><?= Yii::t('main', 'footer_json_data') ?></a>
            <a href="/export.json"
               class="fa far fa-download"
               target="_blank"
            ></a>
        </div>
        <div class="per per-30 footer__language">
            <button
                    value="<?=  /* todo */$_SESSION['$alternative_locale'] ?>"
                    class="language-switcher js_language-switcher">
                <?= $_SESSION['$current_locale'] ?>
            </button>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
