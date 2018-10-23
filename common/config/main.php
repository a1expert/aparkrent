<?php
return [
    'language' => 'ru-RU',
    'sourceLanguage' => 'ru-RU',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'aliases' => [
        'bower' => '@vendor/bower-asset',
        'npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'sms' => [
            'class' => 'common\components\Sms',
            'app_id' => YII_DEBUG ? 'BB7D3637-F87A-AE2C-0C2C-0E789F498E0D' : 'C84CFD53-CCA9-D64C-96C4-3F1688F8A03E',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'defaultTimeZone' => 'Asia/Karachi',
            'timeZone' => 'GMT+05:00',
            'timeFormat' => 'H:i:s',
        ],
    ],
];
