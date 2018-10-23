<?php
/**
 * Created at 07.10.2017 15:47
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace backend\assets;


use yii\web\AssetBundle;

class ClientAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/client.css',
    ];
    public $js = [
        'js/jquery.file-uploader.js',
        'js/client.js',
    ];
    public $depends = [
        'backend\assets\AppAsset',
    ];

}