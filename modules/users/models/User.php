<?php

namespace app\modules\users\models;


use yii\helpers\ArrayHelper;

class User extends \dektrium\user\models\User
{

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),[
            'createAndUpdateUserAddRule' => [
                'class' => 'app\modules\users\components\behaviors\CreateAndDeleteUserBehavior',
                'role' => 'user'
            ],
        ]);
    }

    public function create()
    {
        if ($this->module->enableConfirmation) {

            if ($this->getIsNewRecord() == false) {
                throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
            }

            $transaction = $this->getDb()->beginTransaction();

            try {

                $this->confirmed_at = null;

                $this->trigger(self::BEFORE_CREATE);

                if (!$this->save()) {
                    $transaction->rollBack();
                    return false;
                }

                /** @var Token $token */
                $token = \Yii::createObject(['class' => Token::className(), 'type' => Token::TYPE_CONFIRMATION]);
                $token->link('user', $this);

                $this->mailer->sendWelcomeMessage($this, $token, false);
                $this->trigger(self::AFTER_CREATE);

                $transaction->commit();

                return true;

            } catch (\Exception $e) {
                $transaction->rollBack();
                \Yii::warning($e->getMessage());
                return false;
            }

        } else {

            return parent::create();

        }

    }
}