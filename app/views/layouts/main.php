<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\CmsAsset;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

CmsAsset::register($this);
$this->registerCssFile('/assets/css/main.css');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="open-genes-cms">
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<img src="/assets/images/logo.png"> CMS',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top open-genes-navbar',
        ],
    ]);
    $menuItems = [

    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('common', 'LogIn'), 'url' => ['/cms/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/cms/logout'], 'post')
            . Html::submitButton(
                Yii::t('common', 'LogOut') . ' (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => [
            ['label' => Yii::t('common', 'Gene'), 'url' => ['/gene']],
            ['label' => Yii::t('common', 'Comment cause'), 'url' => ['/comment-cause'], 'visible'=>Yii::$app->user->can('editor')],
            ['label' => Yii::t('common', 'Functional cluster'), 'url' => ['/functional-cluster'], 'visible'=>Yii::$app->user->can('editor')],
            ['label' => Yii::t('common', 'Phylum'), 'url' => ['/age']],
            ['label' => Yii::t('common', 'Protein class'), 'url' => ['/protein-class']],
            [
                'label' => Yii::t('common', 'Research'),
                'items' => [
                    ['label' => Yii::t('common', 'Gene intervention way'), 'url' => '/gene-intervention-way'],
                    '<li class="divider"></li>',
                    ['label' => Yii::t('common', 'Gene intervention method'), 'url' => '/gene-intervention-method'],
                    '<li class="divider"></li>',
                    ['label' => Yii::t('common', 'Intervention result for longevity'), 'url' => '/intervention-result'],
                    '<li class="divider"></li>',
                    ['label' => Yii::t('common', 'Model organism'), 'url' => '/model-organism'],
                    '<li class="divider"></li>',
                    ['label' => Yii::t('common', 'Organism line'), 'url' => '/organism-line'],
                    '<li class="divider"></li>',
                    ['label' => Yii::t('common', 'Organism sex'), 'url' => '/organism-sex'],
                    '<li class="divider"></li>',
                    ['label' => Yii::t('common', 'Sample'), 'url' => '/sample'],
                    '<li class="divider"></li>',
                    ['label' => Yii::t('common', 'Age related change type'), 'url' => '/age-related-change-type'],
                    '<li class="divider"></li>',
                    ['label' => Yii::t('common', 'Vital process'), 'url' => '/vital-process'],
                    '<li class="divider"></li>',
                    ['label' => Yii::t('common', 'Intervention result for vital process'), 'url' => '/intervention-result-for-vital-process'],
                    '<li class="divider"></li>',
                    ['label' => Yii::t('common', 'Progeria syndrome'), 'url' => '/progeria-syndrome'],
                    '<li class="divider"></li>',
                    ['label' => Yii::t('common', 'Genotype'), 'url' => '/genotype'],
                    '<li class="divider"></li>',
                    ['label' => Yii::t('common', 'Protein activity'), 'url' => '/protein-activity'],
                    '<li class="divider"></li>',
                    ['label' => Yii::t('common', 'Gene regulation type'), 'url' => '/gene-regulation-type'],
                    '<li class="divider"></li>',
                    ['label' => Yii::t('common', 'Longevity effect'), 'url' => '/longevity-effect'],
                    '<li class="divider"></li>',
                    ['label' => Yii::t('common', 'Disease'), 'url' => '/disease', 'visible'=>Yii::$app->user->can('editor')],
                ],
            ],
            ['label' => Yii::t('common', 'Users'), 'url' => '/user', 'visible'=>Yii::$app->user->can('controlUsers')],
            ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container content">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
