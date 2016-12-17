<?php

namespace app\modules\users\models;


use app\modules\users\controllers\RegistrationController;
use yii\helpers\Url;

class Token extends \dektrium\user\models\Token
{
    /**
     * @return string
     */
    public function getUrl()
    {
        switch ($this->type) {
            case self::TYPE_CONFIRMATION:
                $route = '/user/registration/confirm';
                break;
            case self::TYPE_RECOVERY:
                $route = '/user/recovery/reset';
                break;
            case self::TYPE_CONFIRM_NEW_EMAIL:
            case self::TYPE_CONFIRM_OLD_EMAIL:
                $route = '/user/settings/confirm';
                break;
            default:
                throw new \RuntimeException();
        }

        return Url::to([$route,
            'id' => $this->user_id,
            'code' => $this->code,
            'type' => RegistrationController::TYPE_CONFIRM_INVITATION
        ], true);
    }
}