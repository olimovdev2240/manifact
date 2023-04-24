<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class ErrorAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "https://fonts.googleapis.com/css?family=Bebas+Neue|Girassol|ZCOOL+KuaiLe&display=swap",
        "css/bootstrap.min.css",
        "fonts/style.css",
        "css/main.css",
        "vendor/particles/particles.css",
    ];
    public $js = [
        "js/jquery.min.js",
        "js/bootstrap.bundle.min.js",
        "js/moment.js",
        "vendor/particles/particles.min.js",
        "vendor/particles/particles-custom-error.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
