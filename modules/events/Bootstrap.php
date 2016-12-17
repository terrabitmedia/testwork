<?php

namespace app\modules\events;


use app\modules\events\components\EventWaiter;
use app\modules\events\components\InstantMessages;
use app\modules\events\components\providers\Dialog;
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

        if ($app->hasModule('events') && ($module = $app->getModule('events')) instanceof Module) {

            if ($app instanceof \yii\console\Application) {
                $app->getModule('events')->controllerNamespace = 'app\modules\events\commands';
            }

            foreach ($app->getModule('events')->modelMap as $name=>$definition) {
                $class = 'app\\modules\\events\\models\\' . $name;
                \Yii::$container->set($class,$definition);
                $modelName = is_array($definition) ? $definition['class'] : $definition;
                $module->modelMap[$name] = $modelName;
            }

            if ($app instanceof \yii\web\Application) {
                EventWaiter::prepare($app->getModule('events')->subDataInEvent, $app->getModule('events')->eventPriority);
                InstantMessages::showMessage(Dialog::className());
            }

            if (!isset($app->get('i18n')->translations['events*'])) {
                $app->get('i18n')->translations['events*'] = [
                    'class'    => PhpMessageSource::className(),
                    'basePath' => __DIR__ . '/messages',
                    'sourceLanguage' => 'en-US'
                ];
            }

        }
    }
}