<?php
/**
 * Created at 06.10.2017 17:24
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace backend\assets;


use yii\web\AssetBundle;

class FaqAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [
        'vendor/tinymce/js/tinymce/tinymce.min.js',
        'js/faq.js',
    ];
    public $depends = [
        'backend\assets\AppAsset',
    ];
}