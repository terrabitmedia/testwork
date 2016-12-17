<?php

namespace tests\components;


use app\modules\events\components\EventWaiter;
use app\modules\events\models\Events;
use app\modules\events\models\Prepared;
use app\modules\news\models\News;
use yii\base\Event;

class EventWaiterTest extends \Codeception\Test\Unit
{
    public function testRun()
    {
        $modelNews = News::findOne(1);
        $event = new Event();
        $event->name = 'afterInsert';
        $event->sender = $modelNews;
        $countWas = Prepared::find()->count();
        EventWaiter::run($event);
        $countNow = Prepared::find()->count();
        $countUserAndProviders = Events::findOne(['name'=>$event->name,'class'=>get_class($modelNews)])->getAssignment()->count();
        $this->assertTrue((($countWas+$countUserAndProviders)==$countNow));
    }
}