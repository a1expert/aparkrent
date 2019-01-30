<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Created at 18.12.2017 19:31
 * @author Tsvetkov Alexander <ac@goldcarrot.ru>
 */

class MapAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [];
    public $js= [
        '//maps.googleapis.com/maps/api/js?key=AIzaSyDp2EMUXX7TYPw5w1gKoQM-aCL5yXTaWBY',
        'js/map.js',
    ];
    public $depends = [
        AppAsset::class,
    ];
}