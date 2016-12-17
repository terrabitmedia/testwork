<?php

namespace app\modules\events\components;


use yii\base\Event;

class SenderEvent extends Event
{
    public $model = null;
    public $message = null;
}