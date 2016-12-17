<?php

namespace tests\components;


use app\modules\events\components\MessageData;
use app\modules\events\components\providers\Dialog;
use app\modules\events\components\providers\Mailer;
use app\modules\events\models\EventProviders;
use app\modules\users\models\User;
use yii\helpers\Json;

class ProvidersTest extends \Codeception\Test\Unit
{
    public function testDialog()
    {
        $modelEventProviders = new EventProviders();
        $messageData = new MessageData([
            'title' => 'title dialog',
            'text' => 'text dialog',
            'user_id' => 1,
            'notice_id' => 1,
            'provider_id' => 1,
            'user' => User::findIdentity(1)
        ]);
        $provider = new Dialog(Json::decode($modelEventProviders->getProviderByClass(Dialog::className())->data));
        $this->assertTrue($provider->send($messageData));
    }

    public function testEmail()
    {
        $modelEventProviders = new EventProviders();
        $messageData = new MessageData([
            'title' => 'title email',
            'text' => 'text email',
            'user_id' => 1,
            'notice_id' => 1,
            'provider_id' => 1,
            'user' => User::findIdentity(1)
        ]);
        $provider = new Mailer(Json::decode($modelEventProviders->getProviderByClass(Mailer::className())->data));
        $this->assertTrue($provider->send($messageData));
    }
}