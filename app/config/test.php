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
    ],
];
