<?php

use app\models\common\User;

$params = require __DIR__ . '/params.php';

$config = [
    'id' => 'genes',
    'name' => 'Open Genes CMS',
    'language' => 'ru-RU',
    'sourceLanguage' => 'en-GB', // todo костыль на то, что у нас переводы не в yii-формате ['english phrase' => 'русская фраза'], переделаем?
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
                'main' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/assets/translations',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app' => 'ar.php',
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
        ],
        'log' => [
            'traceLevel' => getenv('DEBUG') ? 3 : 0,
            'targets' => [
                [
                    'class' => notamedia\sentry\SentryTarget::class,
                    'dsn' => getenv('SENTRY_DSN'),
                    'levels' => ['error', 'warning'],
                    'context' => true,
                    // Additional options for `Sentry\init`:
//                    'clientOptions' => ['release' => 'my-project-name@2.3.12']
                ],
            ],
        ],
    ],
    'defaultRoute' => 'cms/index',
    'params' => $params,
    'runtimePath' => __DIR__ . '/../runtime',
];


return $config;
