<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Nav and menu asset bundle.
 */
class NavAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/sb-admin.css'
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'backend\assets\AppAsset'
    ];
}
