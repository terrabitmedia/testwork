<?php

namespace app\modules\events\commands;


use app\modules\events\components\ListProviders;
use app\modules\events\components\PreparedSender;
use app\modules\events\components\SenderEvent;
use app\modules\events\models\EventProviders;
use app\modules\events\models\Messages;
use app\modules\events\models\Prepared;
use yii\console\Controller;
use yii\helpers\FileHelper;
use yii\helpers\Json;

class ProcessesController extends Controller
{

    const CONST_ATTACH_SELF = 'self';

    public function actionMessages($priority='low')
    {

        $userModel = \Yii::createObject(\Yii::$app->getModule('user')->modelMap['User']);

        $sender = new PreparedSender(
            new ListProviders(
                \Yii::$container->get(EventProviders::className())->find()->all()
            )
        );

        $sender->on(PreparedSender::EVENT_AFTER_SEND, function(SenderEvent $event) {
            \Yii::$container->get(Messages::className())->createNewMessage($event->message);
        });

        try {

            foreach (\Yii::$container->get(Prepared::className())
                         ->getNewPreparedAndLock($priority) as $item) {

                switch ($item->attach) {
                    case self::CONST_ATTACH_SELF:
                        $sender->send($item, $userModel);
                        break;
                    default:
                        foreach (\Yii::$app->getAuthManager()->getUserIdsByRole($item->attach) as $itemUserId) {
                            $sender->send($item, $userModel, $itemUserId);
                        }
                }

                $item->status = 'close';
                $item->save();

            }

        } catch (\Exception $e) {

            echo $e->getTraceAsString();
            return Controller::EXIT_CODE_ERROR;

        }

        echo 'All posts sent.';
        return Controller::EXIT_CODE_NORMAL;

    }

    public function actionScan()
    {

        set_time_limit($this->module->scanTimeLimit);

        $result = FileHelper::findFiles(\Yii::getAlias($this->module->root),[
            'only' => $this->module->patterns
        ]);

        echo Json::encode($result);
        return Controller::EXIT_CODE_NORMAL;

    }

}