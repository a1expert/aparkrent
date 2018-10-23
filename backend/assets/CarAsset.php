<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Created at 13.12.2017 15:19
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

class CarAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [
        'js/car.js',
    ];
    public $depends = [
        AppAsset::class,
    ];
}