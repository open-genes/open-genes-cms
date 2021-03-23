#!/usr/bin/env php
<?php
/**
 * Yii console bootstrap file.
 *
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

defined('YII_DEBUG') or define('YII_DEBUG', true);

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::create(__DIR__ . '/../');
$dotenv->load();

//foreach ($composerAutoload as $autoload) {
//    if (file_exists($autoload)) {
//        require $autoload;
//        $vendorPath = dirname($autoload);
//        break;
//    }
//}

require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

require __DIR__ . '/../config/bootstrap.php';
$config = require __DIR__ . '/../config/console.php';

$application = new yii\console\Application($config);
$exitCode = $application->run();
exit($exitCode);
