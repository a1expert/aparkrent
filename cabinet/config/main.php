<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-cabinet',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'cabinet\controllers',
    'components' => [
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'request' => [
            'csrfParam' => '_csrf-cabinet',
        ],
        'session' => [
            'cookieParams' => [
                'domain' => YII_DEBUG ? '.aparkrent.gc' : '.aparkrent.ru',
                'httpOnly' => true,
            ],
        ],
        'user' => [
            'identityClass' => '\cabinet\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity_user',
                'httpOnly' => true,
                'domain' => YII_DEBUG ? '.aparkrent.gc' : '.aparkrent.ru',
            ]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['sms'],
                    'logFile' => '@cabinet/runtime/logs/sms.log',
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => '/site/index',
                '<controller>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller>/<action>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];
