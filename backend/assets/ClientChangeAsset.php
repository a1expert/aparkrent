<?php
/**
 * Created at 07.10.2017 20:16
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace backend\assets;


use yii\web\AssetBundle;

class ClientChangeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/client-change.js',
    ];
    public $depends = [
        'backend\assets\AppAsset',
    ];
}