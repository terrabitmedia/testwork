<?php

namespace app\modules\users\controllers;


use app\modules\users\models\ConfirmForm;
use yii\web\NotFoundHttpException;

class RegistrationController extends \dektrium\user\controllers\RegistrationController
{

    const TYPE_CONFIRM_REGISTRATION = 'registration';
    const TYPE_CONFIRM_INVITATION = 'invitation';

    public function actionConfirm($id, $code, $type=self::TYPE_CONFIRM_REGISTRATION)
    {
        if ($type==self::TYPE_CONFIRM_INVITATION) {

            $user = $this->finder->findUserById($id);
            $model = new ConfirmForm();

            if ($user === null || $this->module->enableConfirmation == false) {
                throw new NotFoundHttpException();
            }

            if ($model->load(\Yii::$app->request->post()) && $model->validate() && $user->resetPassword($model->password)) {

                $event = $this->getUserEvent($user);

                $this->trigger(self::EVENT_BEFORE_CONFIRM, $event);

                $user->attemptConfirmation($code);

                $this->trigger(self::EVENT_AFTER_CONFIRM, $event);

                return $this->render('/message', [
                    'title'  => \Yii::t('user', 'Account confirmation'),
                    'module' => $this->module,
                ]);

            }

            return $this->render('confirm', [
                'model' => $model
            ]);

        } else {

            return parent::actionConfirm($id, $code);

        }
    }
}