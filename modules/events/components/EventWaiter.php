<?php

namespace app\modules\events\components;


use app\modules\events\models\Events;
use app\modules\events\models\Prepared;
use yii\base\Event;
use yii\base\Object;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class EventWaiter extends Object
{

    /**
     * Prepare all of the events to listen
     * @param $data
     * @param $priority
     */
    public static function prepare($data,$priority)
    {
        foreach (\Yii::$container->get(Events::className())
                     ->getAllEventsGroupBy() as $item) {
            Event::on(
                $item['class'],
                $item['name'],
                [self::className(),'run'],
                $data,
                (!$priority)
            );
        }
    }

    /**
     * Run event for check it
     * @param Event $event
     */
    public static function run(Event $event)
    {
        foreach (\Yii::$container->get(Events::className())
                     ->getEventsByNameAndClass($event->name,get_class($event->sender)) as $item) {
            if (self::checkRules($item->eventRules,$event)) {
                foreach($item->assignment as $assignment) {
                    \Yii::$container->get(Prepared::className())
                        ->createNewPrepared($assignment,$item,$event,\Yii::$app->getUser()->getId());
                }
            }
        }
    }

    /**
     * Checking the event by the rules
     * @param $eventRules
     * @param $event
     * @return bool
     */
    private static function checkRules($eventRules,$event)
    {
        foreach ($eventRules as $ruleDescription) {
            $rule = \Yii::createObject(
                ArrayHelper::merge(
                    Json::decode($ruleDescription['data']),
                    ['class'=>$ruleDescription['class']]
                )
            );
            if ($rule instanceof InterfaceEventRule && $rule->execute(\Yii::$app->getUser(),$event)) { return true; }
        }
        return false;
    }

}