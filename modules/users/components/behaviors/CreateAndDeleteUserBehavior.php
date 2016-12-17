<?php

namespace app\modules\users\components\behaviors;


use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;

class CreateAndDeleteUserBehavior extends Behavior
{
    public $role = null;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'insertUser',
            ActiveRecord::EVENT_AFTER_DELETE => 'deleteUser'
        ];
    }

    public function insertUser(Event $event)
    {
        $role = \Yii::$app->getAuthManager()->getRole($this->role);
        if ($role) {
            \Yii::$app->getAuthManager()->assign($role,$event->sender->id);
        }
    }

    public function deleteUser(Event $event)
    {
        $role = \Yii::$app->getAuthManager()->getRole($this->role);
        if ($role) {
            \Yii::$app->getAuthManager()->revoke($role,$event->sender->id);
        }
    }

}