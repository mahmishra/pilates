<?php

Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');

$commonConfigDir = dirname(__FILE__);

$rootPath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
$libPath = $commonConfigDir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR;

return [
    'adminEmail' => 'noreply@ebizu.com',
    'supportEmail' => 'support@ebizu.com',
    'libPath' => $libPath,
    'components.cache' => [
        'class' => 'yii\caching\FileCache',
    ],
    'components.mail' => [
        'class' => 'yii\swiftmailer\Mailer',
        'viewPath' => '@common/mails',
    ],
    'components.db' => [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=pilates',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
    ],
    'url.rules' => [
        /* for REST please @see http://www.yiiframework.com/wiki/175/how-to-create-a-rest-api/ */
        /* other @see http://www.yiiframework.com/doc/guide/1.1/en/topics.url */
        '<controller:\w+>/<id:\d+>' => '<controller>/view',
        '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
        '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
        '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
        '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
    ],
];
