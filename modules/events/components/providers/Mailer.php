<?php

namespace app\modules\events\components\providers;


use app\modules\events\components\BaseProvider;
use app\modules\events\components\InterfaceMessage;
use app\modules\events\components\InterfaceProvider;
use app\modules\events\models\Messages;

class Mailer extends BaseProvider implements InterfaceProvider
{

    protected $keyContainer = 'mailer';

    public function send(InterfaceMessage $message)
    {
        $message->setFrom(\Yii::$app->getModule('events')->sender);
        if (!isset($message->getUser()['email'])) {
            throw new \Exception('Model User has not field email!');
        }
        $message->setTo($message->getUser()['email']);
        $result = \Yii::$container->get($this->keyContainer)->compose()
            ->setTo($message->getTo())
            ->setFrom([$message->getFrom() => \Yii::$app->name])
            ->setSubject($message->getTitle())
            ->setHtmlBody($message->getText())
            ->send();
        if ($result) {
            $message->setStatus(Messages::CONST_STATUS_DONE);
        } else {
            $message->setStatus(Messages::CONST_STATUS_ERROR);
        }
        return $result;
    }
}