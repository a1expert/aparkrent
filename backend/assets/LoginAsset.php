<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Login menu asset bundle.
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/normalize.css',
        'css/login.css',
    ];
    public $js = [
        'vendor/jquery.inputmask.bundle.js',
        'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
