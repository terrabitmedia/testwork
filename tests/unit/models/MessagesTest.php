<?php

namespace tests\models;


use app\modules\events\components\MessageData;
use app\modules\events\models\Messages;

class MessagesTest extends \Codeception\Test\Unit
{
    public function testCreateNewMessage()
    {
        $message = new MessageData([
            'user_id' => 1,
            'provider_id' => 1,
            'notice_id' => 1,
            'status' => 'wait',
            'title' => 'title test',
            'text' => 'text',
            'from' => 'from@test.ru',
            'to' => 'to@test.ru'
        ]);
        expect(\Yii::$container->get(Messages::className())->createNewMessage($message))->true();
    }

    public function testNewMessageAndDone()
    {
        expect(\Yii::$container->get(Messages::className())->getNewMessageAndDone(1,1))->notEmpty();
    }
}