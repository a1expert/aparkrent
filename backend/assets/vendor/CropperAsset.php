<?php

namespace backend\assets\vendor;

use yii\web\AssetBundle;

class CropperAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'vendor/cropper/cropper.css',
        'js/cropper/cropper.min.css',
    ];
    public $js = [
        'vendor/cropper/cropper.js',
        'js/cropper.js',
        'js/cropper/cropper.min.js',
        'js/cropper/cropperInit.js'
    ];
    public $depends = [
        'backend\assets\AppAsset',
    ];
}