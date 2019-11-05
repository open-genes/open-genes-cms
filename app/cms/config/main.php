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
    'controllerNamespace' => 'cms\controllers',
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
            'name' => 'genes-cms',
        ],
        'errorHandler' => [
            'errorAction' => 'cms/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'cms/index'
            ],
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../runtime/assets',
            'baseUrl' => '/runtime/assets',
        ],
    ],
    'container' => [
        'definitions' => [
            \genes\application\service\GeneInfoServiceInterface::class => \genes\application\service\GeneInfoService::class,
            \genes\infrastructure\dataProvider\GeneDataProviderInterface::class => \genes\infrastructure\dataProvider\GeneDataProvider::class
        ]
    ],
    'defaultRoute' => 'cms/index',
    'params' => $params,
    'runtimePath' => __DIR__ . '/../runtime',
];


return $config;