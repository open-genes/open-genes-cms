<?php

use cms\models\common\User;

return [
    'id' => 'cms-tests',
    'basePath' => dirname(__DIR__),
    'components' => [
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => User::class,
        ],
    ],
];
