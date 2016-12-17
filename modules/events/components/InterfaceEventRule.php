<?php

namespace app\modules\events\components;

use yii\base\Event;
use yii\web\User;

interface InterfaceEventRule
{
    /**
     * @param User $user
     * @param Event $events
     * @return mixed
     */
    public function execute(User $user, Event $events);
}