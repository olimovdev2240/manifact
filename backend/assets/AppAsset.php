<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "css/bootstrap.min.css",
        "fonts/style.css",
        "css/main.css",
        "vendor/daterange/daterange.css",
    ];
    public $js = [
        // "js/jquery.min.js",
        "js/bootstrap.bundle.min.js",
        "js/moment.js",
        "vendor/slimscroll/slimscroll.min.js",
        "vendor/slimscroll/custom-scrollbar.js",
        "vendor/daterange/daterange.js",
        "vendor/daterange/custom-daterange.js",
        "js/main.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
