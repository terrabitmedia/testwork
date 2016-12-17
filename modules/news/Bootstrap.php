<?php

namespace app\modules\news;


use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\i18n\PhpMessageSource;

class Bootstrap implements BootstrapInterface
{

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        if ($app->hasModule('news')) {

            if (!isset($app->get('i18n')->translations['news*'])) {
                $app->get('i18n')->translations['news*'] = [
                    'class'    => PhpMessageSource::className(),
                    'basePath' => __DIR__ . '/messages',
                    'sourceLanguage' => 'en-US'
                ];
            }

        }
    }
}