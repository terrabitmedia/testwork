<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'bootstrap' => [
        'app\modules\events\Bootstrap'
    ],
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'rbac' => 'dektrium\rbac\RbacConsoleModule',
        'events' => [
            'class' => 'app\modules\events\Module',
            'sender' => 'admin@website.ru'
        ],
        'user' => 'dektrium\user\Module'
    ],
    'components' => [
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'scriptUrl' => 'http://rgk.terabit-media.com'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
