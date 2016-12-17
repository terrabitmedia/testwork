<?php

namespace app\modules\events\components;


interface InterfaceProvider
{
    public function send(InterfaceMessage $message);
}