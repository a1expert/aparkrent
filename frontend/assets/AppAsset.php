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
    ];
    public $js = [

        'js/libs.min.js',
        'js/jquery.inputmask.bundle.js',
        'js/tooltipster.bundle.min.js',
        'js/clipboard.min.js',
        'js/main.js',
        '//maps.googleapis.com/maps/api/js?key=AIzaSyDu93I0n3wQBYWgLMiQa8D1mvXmAJ6EzM0',
        'js/map.js',
        'js/device.js',
    ];
    public $depends = [
        YiiAsset::class,
    ];
}
