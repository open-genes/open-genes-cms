<?php

use app\models\common\User;

return [
    'id' => 'cms-tests',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => User::class,
        ],
        'request' => [
            'csrfParam' => '_csrf-genes',
            'cookieValidationKey' => '123',
        ],
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'about' => 'site/about'
            ],
        ],
    ],
];
