<?php

namespace backend\assets;

use backend\assets\vendor\CropperAsset;
use yii\web\AssetBundle;


class ModelAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [
        'js/jquery.gallery-uploader-cropper.js',
        'js/jquery.image-uploader.js',
        'js/jquery.gallery-uploader.js'
    ];
    public $depends = [
        AppAsset::class,
        CropperAsset::class,
    ];
}