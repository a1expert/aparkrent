<?php

namespace frontend\assets;

use frontend\assets\vendor\DateTimePickerAsset;
use yii\web\AssetBundle;


class ReserveAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [
        'js/jquery.gallery-uploader.js',
        'js/dropzone.js',
        'js/reserve.js',
    ];
    public $depends = [
        AppAsset::class,
        DateTimePickerAsset::class,
    ];
}
