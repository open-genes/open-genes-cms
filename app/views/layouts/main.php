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
        $menuItems[] = ['label' => 'Войти', 'url' => ['/cms/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/cms/logout'], 'post')
            . Html::submitButton(
                'Выйти (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => [
            ['label' => 'Гены', 'url' => ['/gene']],
            ['label' => 'Причины отбора', 'url' => ['/comment-cause']],
            ['label' => 'Функциональные кластеры', 'url' => ['/functional-cluster']],
            ['label' => 'Филумы', 'url' => ['/age']],
            [
                'label' => 'Функции гена',
                'items' => [
                    ['label' => 'Виды активности белка', 'url' => '/protein-activity'],
                    '<li class="divider"></li>',
                    ['label' => 'Объекты активности белка', 'url' => '/protein-activity-object'],
                    '<li class="divider"></li>',
                    ['label' => 'Локализация процесса', 'url' => '/process-localization'],
                    '<li class="divider"></li>',
                    ['label' => 'Классы белков', 'url' => '/protein-class', 'visible'=>Yii::$app->user->can('editor')],
                ],
            ],
            [
                'label' => 'Исследования',
                'items' => [
                    ['label' => 'Методы вмешательства', 'url' => '/gene-intervention'],
                    '<li class="divider"></li>',
                    ['label' => 'Результаты вмешательства (для продолжительности жизни)', 'url' => '/intervention-result'],
                    '<li class="divider"></li>',
                    ['label' => 'Модельные организмы', 'url' => '/model-organism'],
                    '<li class="divider"></li>',
                    ['label' => 'Линии организмов', 'url' => '/organism-line'],
                    '<li class="divider"></li>',
                    ['label' => 'Образцы тканей', 'url' => '/sample'],
                    '<li class="divider"></li>',
                    ['label' => 'Виды возрастных изменений гена/белка', 'url' => '/age-related-change-type'],
                    '<li class="divider"></li>',
                    ['label' => 'Процессы', 'url' => '/vital-process'],
                    '<li class="divider"></li>',
                    ['label' => 'Результаты вмешательства (для процессов)', 'url' => '/intervention-result-for-vital-process'],
                    '<li class="divider"></li>',
                    ['label' => 'Прогерические синдромы', 'url' => '/progeria-syndrome'],
                    '<li class="divider"></li>',
                    ['label' => 'Аллельные полиморфизмы', 'url' => '/genotype'],
                    '<li class="divider"></li>',
                    ['label' => 'Виды активности белка', 'url' => '/protein-activity'],
                    '<li class="divider"></li>',
                    ['label' => 'Эффекты в долголетии', 'url' => '/longevity-effect'],
                    '<li class="divider"></li>',
                    '<li class="divider"></li>',
                    ['label' => 'Заболевания', 'url' => '/disease', 'visible'=>Yii::$app->user->can('editor')],
                ],
            ],
            ['label' => 'Пользователи', 'url' => '/user', 'visible'=>Yii::$app->user->can('controlUsers')],
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
