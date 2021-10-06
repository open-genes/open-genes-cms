<?php

use app\models\common\User;

$params = require __DIR__ . '/params.php';

$config = [
    'id' => 'genes',
    'name' => 'Open Longevity Genes',
    'language' => 'en',
//    'sourceLanguage' => 'en-GB', // todo костыль на то, что у нас переводы не в yii-формате ['english phrase' => 'русская фраза'], переделаем?
    'sourceLanguage' => 'en-EN',
    'basePath' => dirname(__DIR__),
    'homeUrl' => '/',
    'controllerNamespace' => 'app\controllers',
    'vendorPath' => '@app/vendor',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-genes',
            'cookieValidationKey' => '123',
        ],
        'i18n' => [
            'translations' => [
                'common' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/assets/translations',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app' => 'ar.php',
                    ],
//                    'sourceLanguage' => 'en-US',
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
        'user' => [
            'identityClass' => User::class,
            'enableAutoLogin' => true,
            'loginUrl' => ['/cms/login'],
            'identityCookie' => ['name' => '_identity-genes', 'httpOnly' => true],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => getenv('SMTP_USER'),
                'password' => getenv('SMTP_PASS'),
                'port' => '587',
                'encryption' => 'tls',
            ],
        ]
    ],
    'defaultRoute' => 'cms/index',
    'params' => $params,
    'runtimePath' => __DIR__ . '/../runtime',
];


return $config;
