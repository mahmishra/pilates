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
        'dsn' => 'mysql:host=ikargodb.cyfkaa5qbt52.ap-southeast-1.rds.amazonaws.com;dbname=ikargo_db',
        'username' => 'ikargo',
        'password' => 'ikargo4$',
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
    'frontendUrl' => (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . 'ikargo.ebizu.com/',
    'backendUrl' => (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . 'adminikargo.ebizu.com/',
    'imageTempPath' => $rootPath . 'temp' . DIRECTORY_SEPARATOR,
    'businessPath' => $rootPath . 'media' . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'business' . DIRECTORY_SEPARATOR,
    'memberPath' => $rootPath . 'media' . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'member' . DIRECTORY_SEPARATOR,
    'mobilePath' => $rootPath . 'media' . DIRECTORY_SEPARATOR . 'mobile' . DIRECTORY_SEPARATOR . 'business' . DIRECTORY_SEPARATOR,
    'mobileMemberPath' => $rootPath . 'media' . DIRECTORY_SEPARATOR . 'mobile' . DIRECTORY_SEPARATOR . 'member' . DIRECTORY_SEPARATOR,
    'businessTempPath' => $rootPath . 'media' . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'business' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR,
    'memberTempPath' => $rootPath . 'media' . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'member' . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR,
    'memberTempUrl' => 'https://d1307f5mo71yg9.cloudfront.net/images/media/web/member/temp/',
    'memberUrl' => 'https://d1307f5mo71yg9.cloudfront.net/images/media/web/member/',
    'businessUrl' => 'https://d1307f5mo71yg9.cloudfront.net/images/media/web/business/',
    'businessTempUrl' => 'https://d1307f5mo71yg9.cloudfront.net/images/media/web/business/temp/',
    'imageUrl' => 'https://d1307f5mo71yg9.cloudfront.net/images/',
    'dropUrl' => 'https://d1307f5mo71yg9.cloudfront.net/drops/',
    // 'session_timeout'=>7200,
    's3key' => 'AKIAJ2UQQOLWLMFWSGDQ',
    's3secret' => '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',
    's3region' => 'ap-southeast-1',
    's3bucket' => 'ebizu-production'
];
