<?php

namespace tests\components;


use app\modules\events\components\rules\ChangeFieldRule;
use app\modules\events\components\rules\EmptyFieldRule;
use app\modules\events\components\rules\FilledFieldRule;
use app\modules\users\models\User;
use yii\base\Event;

class RulesTest extends \Codeception\Test\Unit
{
    public function testChangeFieldRule()
    {
        $user = User::findIdentity(1);
        \Yii::$app->getUser()->setIdentity($user);
        $event = new Event();
        $event->sender = $user;
        $user->username = '012931092';
        $component = new ChangeFieldRule(['fields'=>'username']);
        $this->assertTrue($component->execute(\Yii::$app->getUser(),$event));
    }

    public function testEmptyFieldRule()
    {
        $user = User::findIdentity(1);
        \Yii::$app->getUser()->setIdentity($user);
        $event = new Event();
        $event->sender = $user;
        $user->username = '';
        $component = new EmptyFieldRule(['fields'=>'username']);
        $this->assertTrue($component->execute(\Yii::$app->getUser(),$event));
    }

    public function testFilledFieldRule()
    {
        $user = User::findIdentity(1);
        \Yii::$app->getUser()->setIdentity($user);
        $event = new Event();
        $event->sender = $user;
        $user->username = '432423423432';
        $component = new FilledFieldRule(['fields'=>'username']);
        $this->assertTrue($component->execute(\Yii::$app->getUser(),$event));
    }
}