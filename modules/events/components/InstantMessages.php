<?php

namespace app\modules\events\components;


use app\modules\events\models\EventProviders;
use app\modules\events\models\Messages;
use yii\base\Object;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\jui\Dialog;
use yii\web\View;

class InstantMessages extends Object
{

    public static function showMessage($providerClass)
    {
        if (!\Yii::$app->getUser()->getIsGuest() && $providerClass) {
            \Yii::$app->view->on(View::EVENT_END_BODY, function () use ($providerClass) {
                $modelProvider = \Yii::$container->get(EventProviders::className())->getProviderByClass($providerClass);
                if ($modelProvider) {
                    $optionsDialog = Json::decode($modelProvider['data']);
                    $dialogConfig = [
                        'id' => 'dialog-id',
                        'clientOptions' => [
                            'modal' => true,
                            'title' => \Yii::t('events','The notification on the site'),
                            'autoOpen' => true,
                            'height' => 'auto',
                            'min-height' => 350,
                            'width' => 600
                        ]
                    ];
                    if (isset($optionsDialog['config']['dialog'])) {
                        $dialogConfig = ArrayHelper::merge($dialogConfig,$optionsDialog['config']['dialog']);
                    }
                    $modelNewMessage = \Yii::$container->get(Messages::className())
                        ->getNewMessageAndDone($modelProvider->provider_id,\Yii::$app->getUser()->getId());
                    if ($modelNewMessage) {
                        $dialogConfig['clientOptions']['title'] = $modelNewMessage['title'];
                        Dialog::begin($dialogConfig);
                        echo $modelNewMessage['text'];
                        Dialog::end();
                    }
                }
            });
        }
    }

}