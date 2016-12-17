<?php

namespace app\modules\events\components\providers;


use app\modules\events\components\BaseProvider;
use app\modules\events\components\InterfaceMessage;
use app\modules\events\components\InterfaceProvider;
use app\modules\events\models\Messages;

class Dialog extends BaseProvider implements InterfaceProvider
{

    public function send(InterfaceMessage $message)
    {
        $message->setFrom(NULL);
        $message->setTo(NULL);
        $message->setStatus(Messages::CONST_STATUS_WAIT);
        return true;
    }
}