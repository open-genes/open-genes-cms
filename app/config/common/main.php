<?php

use app\models\common\User;

$config = [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(__DIR__) . '/../vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => [
            'charset' => 'utf8',
            'class' => yii\db\Connection::class,
            'dsn' => getenv('DB_DSN'),
            'username' => getenv('DB_USER'),
            'password' => getenv('DB_PASS'),
        ],
        'user' => [
            'identityClass' => User::class,
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-genes', 'httpOnly' => true],
        ],
        'authManager' => [
            'class' => yii\rbac\DbManager::class,
            // uncomment if you want to cache RBAC items hierarchy
            // 'cache' => 'cache',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'about' => 'site/about'
            ],
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/assets/translations',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                    ],
                ],
            ],
        ],
    ],
];

if (getenv('DEBUG')) {
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
            'generators' => [
            'cms_model' => [
                'class' => \app\generators\model\Generator::class,
                'templates' => [
                    'cms_model' => '@app/generator/model/default',
                ]
            ],
            'cms_crud' => [
                'class' => \app\generators\crud\Generator::class,
                'templates' => [
                    'cms_crud' => '@app/generator/crud/default',
                ]
            ]
        ],
    ];
}

return $config;

