<?php

namespace backend\assets;

use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;
use yii\web\YiiAsset;
use yii\jui\JuiAsset;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'font-awesome/css/font-awesome.min.css',
        'vendor/magnific-popup/magnific-popup.css',
        'vendor/toastr/toastr.min.css',
        'css/normalize.css',
        'css/site.css',
    ];
    public $js = [
        'vendor/magnific-popup/jquery.magnific-popup.min.js',
        'vendor/jquery.inputmask.bundle.js',
        'vendor/toastr/toastr.min.js',
        'js/main.js',
    ];
    public $depends = [
        YiiAsset::class,
        JqueryAsset::class,
        BootstrapAsset::class,
        JuiAsset::class,
    ];
}
