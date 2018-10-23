<?php

namespace backend\assets;

use yii\web\AssetBundle;

class ReserveAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/reserve.css',
    ];
    public $js = [
        'js/jquery.file-uploader.js',
        'js/reserve.js',
        'js/child-reserve.js',
    ];
    public $depends = [
        'backend\assets\AppAsset',
    ];

}