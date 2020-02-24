<?php


$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/params.php'
);

$config = [
    'id' => 'genes',
    'name' => 'Open Longevity Genes',
    'language' => 'ru-RU',
    'sourceLanguage' => 'en-GB', // todo костыль на то, что у нас переводы не в yii-формате ['english phrase' => 'русская фраза'], переделаем?
    'basePath' => dirname(__DIR__),
    'homeUrl' => '/',
    'controllerNamespace' => 'genes\controllers',
    'vendorPath' => '@common/vendor',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-genes',
            'cookieValidationKey' => '123',
        ],
        'i18n' => [
            'translations' => [
                'main' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => __DIR__ . '/../assets/translations',
//                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'main' => 'main.php',
                    ],
                ],
            ],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'genes',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../runtime/assets',
            'baseUrl' => '/runtime/assets',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'about' => 'site/about',
                'api/gene/<id:\d+>' => 'api/gene',
                'api/by-functional-cluster/<ids>' => 'api/by-functional-cluster',
                'api/by-expression-change/<expressionChange>' => 'api/by-expression-change'
            ],
        ],
    ],
    'container' => [
        'definitions' => [
            \genes\application\service\GeneInfoServiceInterface::class => \genes\application\service\GeneInfoService::class,
            \genes\application\service\PhylumInfoServiceInterface::class => \genes\application\service\PhylumInfoService::class,
            \genes\application\dto\GeneDtoAssemblerInterface::class => \genes\application\dto\GeneDtoAssembler::class,
            \genes\application\dto\ResearchDtoAssemblerInterface::class => \genes\application\dto\ResearchDtoAssembler::class,
            \genes\infrastructure\dataProvider\GeneDataProviderInterface::class => function(\yii\di\Container $container){
                return new \genes\infrastructure\dataProvider\GeneDataProvider(Yii::$app->language);
            },
            \genes\infrastructure\dataProvider\GeneExpressionDataProviderInterface::class => \genes\infrastructure\dataProvider\GeneExpressionDataProvider::class,
            \genes\infrastructure\dataProvider\GeneFunctionsDataProviderInterface::class => \genes\infrastructure\dataProvider\GeneFunctionsDataProvider::class,
            \genes\infrastructure\dataProvider\GeneResearchesDataProviderInterface::class => \genes\infrastructure\dataProvider\GeneResearchesDataProvider::class,
            \genes\infrastructure\dataProvider\PhylumDataProviderInterface::class => \genes\infrastructure\dataProvider\PhylumDataProvider::class
        ]
    ],
    'defaultRoute' => 'site/index',
    'params' => $params,
    'runtimePath' => __DIR__ . '/../runtime',
    'on beforeAction' => function ($event) { // todo привести язык на фронте к стандарту ln-LN
        $language = $_GET['lang'] ?? $_COOKIE['lang'] ?? Yii::$app->language;
        $language = (new \genes\helpers\LanguageMapHelper())->getMappedLanguage($language);
        if(Yii::$app->language != $language) {
            Yii::$app->language = $language;
        }
        if(!isset($_COOKIE['lang']) || $_COOKIE['lang'] != $language) {
            setcookie('lang', $language, $expire = 0, $path = "/");
        }
    },
];


if (YII_DEBUG) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*'],
    ];
}

return $config;