<?php

namespace frontend\assets;

use yii\jui\JuiAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;
use yii\web\YiiAsset;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/normalize.css',
        'css/libs.min.css',
        'css/tooltipster.bundle.css',
        'css/main.css',
        'vendor/fancybox/jquery.fancybox.min.css',
        'vendor/daterangepicker/daterangepicker.min.css',
    ];
    public $js = [
        'js/libs.min.js',
        'js/jquery.inputmask.bundle.js',
        'js/tooltipster.bundle.min.js',
        'js/clipboard.min.js',
        'js/main.js',
        '//maps.googleapis.com/maps/api/js?key=AIzaSyAmpQVMbrChKegYaqZa9Lex7grtCvxVZ4M',
        'js/map.js',
        'js/device.js',
        'vendor/fancybox/jquery.fancybox.min.js',
        'vendor/daterangepicker/moment.js',
        'vendor/daterangepicker/jquery.daterangepicker.min.js',
    ];
    public $depends = [
        YiiAsset::class,
    ];
}
