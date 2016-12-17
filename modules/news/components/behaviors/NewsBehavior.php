<?php

namespace app\modules\news\components\behaviors;


use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;

class NewsBehavior extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate'
        ];
    }

    public function beforeInsert(Event $event)
    {
        $event->sender->setAttribute('author_id',\Yii::$app->getUser()->getId());
        $event->sender->setAttribute('create_at',time());
        $this->beforeUpdate($event);
    }

    public function beforeUpdate(Event $event)
    {
        if (!empty($event->sender->getAttribute('full_text'))) {
            $event->sender->setAttribute('short_text',mb_substr($this->owner->full_text,0,500).'...');
        }
        $event->sender->setAttribute('update_at',time());
    }

}