<?php

namespace tests\models;


use app\modules\events\models\EventAssignment;
use app\modules\events\models\Events;
use app\modules\events\models\Prepared;
use yii\base\Event;
use yii\base\Model;

class PreparedTest extends \Codeception\Test\Unit
{
    public function testCreateNewPrepared()
    {
        $modelAssignment = new EventAssignment();
        $modelAssignment->attach = 'user';
        $modelAssignment->provider_id = 1;
        $modelEvents = new Events();
        $modelEvents->event_id = 1;
        $modelEvents->notice_id = 1;
        $event = new Event();
        $event->name = 'name event';
        $event->sender = new Model();
        $event->data = [];
        expect(\Yii::$container->get(Prepared::className())->createNewPrepared($modelAssignment,$modelEvents,$event,1))->true();
    }

    public function testGetNewPreparedAndLock()
    {
        expect(\Yii::$container->get(Prepared::className())->getNewPreparedAndLock('low'))->notEmpty();
    }
}