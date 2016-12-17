<?php

namespace app\modules\events\components\rules;


use app\modules\events\components\InterfaceEventRule;
use yii\base\Event;
use yii\base\Object;
use yii\web\User;

class FakeRule extends Object implements InterfaceEventRule
{

    /**
     * @param User $user
     * @param Event $events
     * @return mixed
     */
    public function execute(User $user, Event $events)
    {
        return true;
    }
}