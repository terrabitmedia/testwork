<?php

namespace app\modules\events\components\behaviors;


use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\Json;

class EmptyFieldJsonBehavior extends Behavior
{
    public $attributes = [];

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
        ];
    }

    public function beforeValidate(Event $event)
    {
        foreach ($this->attributes as $attribute) {
            if ($event->sender->hasAttribute($attribute) &&
                    empty($event->sender->getAttribute($attribute)) &&
                        !method_exists($event->sender,'search')) {
                $event->sender->setAttribute($attribute,Json::encode([]));
            }
        }
    }

}