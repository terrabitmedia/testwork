<?php

namespace app\modules\events\components\rules;


use app\modules\events\components\InterfaceEventRule;
use yii\base\Event;
use yii\base\Model;
use yii\base\Object;
use yii\web\User;

class FilledFieldRule extends Object implements InterfaceEventRule
{

    public $fields = [];

    /**
     * @param User $user
     * @param Event $events
     * @return mixed
     */
    public function execute(User $user, Event $events)
    {
        if ($events->sender instanceof Model) {
            foreach ($events->sender->getAttributes((array)$this->fields) as $field) {
                if (!empty($field)) {
                    return true;
                }
            }
        }
        return false;
    }
}