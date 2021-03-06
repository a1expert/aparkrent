<?php

namespace cabinet\assets;

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
        'js/main.js',
    ];
    public $depends = [
        YiiAsset::class,
        JqueryAsset::class,
        JuiAsset::class,
    ];
}
