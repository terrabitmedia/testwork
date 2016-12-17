<?php

namespace app\modules\users\models;


use yii\base\Model;

class ConfirmForm extends Model
{

    /**
     * @var string
     */
    public $password;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password' => \Yii::t('user', 'Password'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            'passwordRequired' => ['password', 'required'],
            'passwordLength' => ['password', 'string', 'max' => 72, 'min' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 'enter-password-form';
    }

}