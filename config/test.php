<?php

$config =  yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/web.php'),
    [
        'id' => 'app-tests',
        'components' => [
            'db' => require(__DIR__ . '/test_db.php')
        ]
    ]
);
return $config;