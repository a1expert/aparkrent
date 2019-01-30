<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
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
                    'levels' => ['info'],
                    'categories' => ['payments'],
                    'logFile' => '@frontend/runtime/logs/payments.log',
                ]
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => '/site/index',
                '/<action:\w+>/<id:\d+>' => 'site/<action>',
                'prokat-avto-surgut' => '/site/catalog',
                'jobs' => '/site/jobs',
                'conditions' => '/site/conditions',
                'contacts' => '/site/contacts',
                'about-company' => '/site/about-company',
            ],
        ],
    ],
    'params' => $params,
];
