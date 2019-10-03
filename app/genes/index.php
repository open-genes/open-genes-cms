<?php
require __DIR__ . '/../common/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::create(__DIR__ . '../..');
$dotenv->load();

defined('YII_DEBUG') or define('YII_DEBUG', getenv('DEBUG'));
defined('YII_ENV') or define('YII_ENV', getenv('ENV'));

require __DIR__ . '/../common/vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../common/config/bootstrap.php';
require __DIR__ . '/config/bootstrap.php';

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../common/config/main.php',
    require __DIR__ . '/config/main.php'
);

(new yii\web\Application($config))->run();
