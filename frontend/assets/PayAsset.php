<?php
/**
 * Created at 26.10.2017 19:01
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class PayAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [
        'js/pay.js',
    ];
    public $depends = [
        AppAsset::class,
    ];
}