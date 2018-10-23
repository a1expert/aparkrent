<?php
/**
 * Created at 29.11.2017 15:48
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

namespace frontend\assets\vendor;

use yii\web\AssetBundle;
use yii\web\YiiAsset;

class DateTimePickerAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'vendor/datetimepicker/jquery.datetimepicker.css',
    ];
    public $js = [
        'vendor/datetimepicker/jquery.datetimepicker.full.js',
    ];
    public $depends = [
        YiiAsset::class,
    ];
}