<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/params.php'
);

$config = [
    'id' => 'genes-console',
    'name' => 'Open Longevity Genes',
    'language' => 'ru-RU',
    'sourceLanguage' => 'en-GB', // todo костыль на то, что у нас переводы не в yii-формате ['english phrase' => 'русская фраза'], переделаем?
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'common\console\controllers',
    'vendorPath' => '@common/vendor',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'db' => [
            'charset' => 'utf8',
            'class' => yii\db\Connection::class,
            'dsn' => getenv('DB_DSN'),
            'username' => getenv('DB_USER'),
            'password' => getenv('DB_PASS'),
        ],
        'authManager' => [
            'class' => yii\rbac\DbManager::class,
            // uncomment if you want to cache RBAC items hierarchy
            // 'cache' => 'cache',
        ],
        'i18n' => [
            'translations' => [
                'main' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => __DIR__ . '/../../genes/assets/translations',
                    'sourceLanguage' => 'en-GB',
                    'fileMap' => [
                        'main' => 'main.php',
                    ],
                ],
            ],
        ],
    ],
    'container' => [
        'definitions' => [
            \genes\application\service\GeneInfoServiceInterface::class => \genes\application\service\GeneInfoService::class,
            \genes\infrastructure\dataProvider\GeneDataProviderInterface::class => \genes\infrastructure\dataProvider\GeneDataProvider::class
        ]
    ],
    'params' => $params,
    'runtimePath' => __DIR__ . '/../runtime',
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