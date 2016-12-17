<?php

namespace tests\models;


use app\modules\events\models\Events;
use app\modules\news\models\News;

class EventProvidersMethodTest extends \Codeception\Test\Unit
{
    public function testProviderByClass()
    {
        expect(\Yii::$container->get(Events::className())->getEventsByNameAndClass('afterInsert',News::className()))->notEmpty();
    }
}