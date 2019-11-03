<?php

namespace genes\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class OpenGenesAsset extends AssetBundle
{
    public $basePath = '@webroot/runtime/assets';
    public $baseUrl = '@web/assets';
    public $css = [
        'css/style.css',
        'css/font-awesome/brands.min.css',
        'css/font-awesome/light.min.css',
        'css/font-awesome/solid.min.css',
        'css/font-awesome/fontawesome.min.css',
        'css/font-awesome/regular.min.css',
    ];
    public $js = [
        'js/jquery-3.4.1.min.js',
        'js/app.min.js',
    ];
    public $depends = [
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
