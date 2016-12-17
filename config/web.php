<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'name' => 'Test project of articles',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'app\modules\news\Bootstrap',
        'app\modules\events\Bootstrap'
    ],
    'defaultRoute' => '/news/news/index',
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'admins' => ['admin'],
            'modelMap' => [
                'User' => [
                    'class' => 'app\modules\users\models\User',
                    'as createAndUpdateUserHasProvider' => [
                        'class' => 'app\modules\events\components\behaviors\CreateAndDeleteUserBehavior'
                    ],
                ]
            ],
            'controllerMap' => [
                'admin' => [
                    'class' => 'app\modules\users\controllers\AdminController',
                    'viewPath' => '@app/modules/users/views/admin'
                ],
                'registration' => [
                    'class' => 'app\modules\users\controllers\RegistrationController',
                    'viewPath' => '@app/modules/users/views/registration'
                ],
                'settings' => [
                    'class' => 'app\modules\users\controllers\SettingsController',
                    'viewPath' => '@app/modules/users/views/settings'
                ]
            ],
        ],
        'rbac' => [
            'class' => 'dektrium\rbac\RbacWebModule'
        ],
        'news' => [
            'class' => 'app\modules\news\Module',
        ],
        'events' => [
            'class' => 'app\modules\events\Module',
            'sender' => 'admin@website.ru'
        ]
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'WgqNzXFB2lEYAa4F9Q2PeZr-tMPJ9RDr',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'localhost',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => 'admin@test-rgk.terabit-media.com',
                'password' => '123456',
                'port' => '587', // Port 25 is a very common port too
                'encryption' => 'tls', // It is often used, check your provider or mail server specs
            ],
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
        'authManager' => [
            'class' => 'dektrium\rbac\components\DbManager',
            'defaultRoles' => ['guest']
        ],
        'consoleRunner' => [
            'class' => 'toriphes\console\Runner'
        ],
        'db' => require(__DIR__ . '/db.php')
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs'=>['*']
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs'=>['*']
    ];
}

return $config;
