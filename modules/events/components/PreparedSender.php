<?php

namespace app\modules\events\components;


use app\modules\events\models\Prepared;
use app\modules\events\models\ProviderHasUser;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class PreparedSender extends Component
{

    const EVENT_AFTER_SEND = 'afterSend';
    const EVENT_BEFORE_SEND = 'beforeSend';
    const EVENT_SUCCESS_SEND = 'successSend';
    const EVENT_ERROR_SEND = 'errorSend';

    private $_providers = [];

    public function __construct(ListProviders $providers)
    {
        $this->_providers = $providers;
    }

    public function send(Prepared $prepared, $userModel, $userId = null)
    {

        $event = new SenderEvent();
        $event->model = $prepared;

        $this->trigger(self::EVENT_BEFORE_SEND,$event);

        $dataPrepared = Json::decode($prepared['data']);

        if (!isset($dataPrepared['model'],$dataPrepared['user_id'])) {
            throw new \Exception("Not found important properties!");
        }

        $userId = empty($userId)?$dataPrepared['user_id']:$userId;

        $modelUserHasProvider = \Yii::$container->get(ProviderHasUser::className())->findOne([
            'user_id' => $userId,
            'provider_id' => $prepared->provider_id
        ]);

        if ($this->_providers->hasProvider($prepared->provider['class']) && $modelUserHasProvider) {

            $notice = \Yii::createObject(ArrayHelper::merge(
                ['class' => $prepared->notice['class']],
                Json::decode($prepared->notice['data'])
            ));

            $modelFromEvent = unserialize($dataPrepared['model']);

            $user = $userModel->findOne($userId);

            $notice->processData($modelFromEvent,$user,$prepared->notice['template'],$prepared->notice['title_template']);

            $message = new MessageData([
                'title' => $notice->getTitle(),
                'text' => $notice->getText(),
                'user_id' => $userId,
                'notice_id' => $prepared->notice_id,
                'provider_id' => $prepared->provider_id,
                'user' => $user
            ]);

            $event->message = $message;

            if ($this->_providers->getProviderInstance($prepared->provider['class'])->send($message)) {
                $this->trigger(self::EVENT_SUCCESS_SEND,$event);
            } else {
                $this->trigger(self::EVENT_ERROR_SEND,$event);
            }

        }

        $this->trigger(self::EVENT_AFTER_SEND,$event);

    }

}