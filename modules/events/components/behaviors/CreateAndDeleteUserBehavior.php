<?php

namespace app\modules\events\components\behaviors;


use app\modules\events\models\EventProviders;
use app\modules\events\models\ProviderHasUser;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;

class CreateAndDeleteUserBehavior extends Behavior
{

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'insertUser',
            ActiveRecord::EVENT_AFTER_DELETE => 'deleteUser'
        ];
    }

    public function insertUser(Event $event)
    {
        foreach (EventProviders::find()->all() as $itemProvider) {
            $model = new ProviderHasUser();
            $model->provider_id = $itemProvider->provider_id;
            $model->user_id = $event->sender->id;
            $model->save();
        }
    }

    public function deleteUser(Event $event)
    {
        ProviderHasUser::deleteAll(['user_id' => $event->sender->id]);
    }

}