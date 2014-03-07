<?php

$rootDir = dirname(dirname(__DIR__));

$params = array_merge(
        require($rootDir . '/common/config/params.php'), require($rootDir . '/common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'name' => 'Ebizu',
    'preload' => ['log'],
    'vendorPath' => $rootDir . '/vendor',
    'controllerNamespace' => 'frontend\controllers',
    'extensions' => require($rootDir . '/vendor/yiisoft/extensions.php'),
    'components' => [
        'db' => $params['components.db'],
        'cache' => $params['components.cache'],
        'mail' => $params['components.mail'],
        'hasher' => [
            'class' => 'yii\phpass\Phpass',
            'hashPortable' => false,
            'hashCostLog2' => 8
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'idVar' => 'customer'
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix' => '/',
            'rules' => $params['url.rules'],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
