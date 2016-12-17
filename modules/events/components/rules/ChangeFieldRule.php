<?php

namespace app\modules\events\components\rules;


use app\modules\events\components\InterfaceEventRule;
use yii\base\Event;
use yii\base\Object;
use yii\db\BaseActiveRecord;
use yii\web\User;

class ChangeFieldRule extends Object implements InterfaceEventRule
{

    public $fields = [];

    /**
     * @param User $user
     * @param Event $events
     * @return mixed
     */
    public function execute(User $user, Event $events)
    {
        foreach ((array)$this->fields as $field) {
            if ($events->sender instanceof BaseActiveRecord && $events->sender->isAttributeChanged($field)) {
                return true;
            }
        }
        return false;
    }
}