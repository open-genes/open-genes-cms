<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class CmsAsset extends AssetBundle
{
    public $basePath = '@webroot/runtime/assets';
    public $baseUrl = '@web/assets';

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
