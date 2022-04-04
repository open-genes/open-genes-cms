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
            ['label' => 'Сущности в генах',
                'items' => [
                    ['label' => 'Причины отбора', 'url' => ['/comment-cause'], 'visible' => Yii::$app->user->can('editor')],
                    ['label' => 'Возрастозависимые процессы', 'url' => ['/functional-cluster'], 'visible' => Yii::$app->user->can('editor')],
                    ['label' => 'Филумы', 'url' => ['/age']],
                    ['label' => 'Заболевания', 'url' => '/disease', 'visible' => Yii::$app->user->can('editor')],
                ],
            ],

            [
                'label' => 'Исследования - прод.жизни',
                'items' => [
                    ['label' => 'Способы воздействия', 'url' => '/gene-intervention-way'],
                    '<li class="divider"></li>',
                    ['label' => 'Методы вмешательства', 'url' => '/gene-intervention-method'],
                    '<li class="divider"></li>',
                    ['label' => 'Результаты вмешательства (для продолжительности жизни)', 'url' => '/intervention-result'],
                    '<li class="divider"></li>',
                    ['label' => 'Препараты', 'url' => '/active-substance', 'visible' => Yii::$app->user->can('editor')],
                    '<li class="divider"></li>',
                    ['label' => 'Пол', 'url' => '/organism-sex', 'visible' => Yii::$app->user->can('editor')],
                    '<li class="divider"></li>',
                    ['label' => 'Способы доставки препарата', 'url' => '/active-substance-delivery-way', 'visible' => Yii::$app->user->can('editor')],
                    '<li class="divider"></li>',
                    ['label' => 'Основной эффект', 'url' => '/experiment-main-effect', 'visible' => Yii::$app->user->can('editor')],
                    '<li class="divider"></li>',
                    ['label' => 'Статистическая значимость', 'url' => '/statistical-significance', 'visible' => Yii::$app->user->can('editor')],
                    '<li class="divider"></li>',
                    ['label' => 'Стадия развития в начале эксперимента', 'url' => '/treatment-stage-of-development', 'visible' => Yii::$app->user->can('editor')],
                    '<li class="divider"></li>',
                    ['label' => 'Единицы измерения времени', 'url' => '/treatment-time-unit', 'visible' => Yii::$app->user->can('editor')],
                    '<li class="divider"></li>',
                    ['label' => 'Генотип', 'url' => '/genotype', 'visible' => Yii::$app->user->can('editor')],
                    '<li class="divider"></li>',
                    ['label' => 'Диеты', 'url' => '/diet', 'visible' => Yii::$app->user->can('editor')],
                ],
            ],
            [
                'label' => 'Исследования - другое',
                'items' => [
                    ['label' => 'Классы белков', 'url' => ['/protein-class']],
                    '<li class="divider"></li>',
                    ['label' => 'Объекты исследований (модельные организмы)', 'url' => '/model-organism'],
                    '<li class="divider"></li>',
                    ['label' => 'Линии организмов', 'url' => '/organism-line'],
                    '<li class="divider"></li>',
                    ['label' => 'Пол организмов', 'url' => '/organism-sex'],
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
                    ['label' => 'Аллельные полиморфизмы', 'url' => '/polymorphism'],
                    '<li class="divider"></li>',
                    ['label' => 'Виды активности белка', 'url' => '/protein-activity'],
                    '<li class="divider"></li>',
                    ['label' => 'Виды регуляции гена', 'url' => '/gene-regulation-type'],
                    '<li class="divider"></li>',
                    ['label' => 'Эффекты в долголетии', 'url' => '/longevity-effect'],
                    '<li class="divider"></li>',
                    ['label' => 'Метод измерения', 'url' => '/measurement-type'],
                    '<li class="divider"></li>',
                    ['label' => 'Оценка экспрессии по', 'url' => '/expression-evaluation'],
                    '<li class="divider"></li>',

                ],
            ],
            ['label' => 'Пользователи', 'url' => '/user', 'visible' => Yii::$app->user->can('controlUsers')],
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
