<?php

namespace app\modules\events\models;

use dektrium\user\models\User;
use Yii;

/**
 * This is the model class for table "{{%provider_has_user}}".
 *
 * @property integer $provider_id
 * @property integer $user_id
 */
class ProviderHasUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%provider_has_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['provider_id', 'user_id'], 'integer'],
            [['provider_id'], 'exist', 'skipOnError' => true, 'targetClass' => EventProviders::className(), 'targetAttribute' => ['provider_id' => 'provider_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'provider_id' => Yii::t('events', 'Provider ID'),
            'user_id' => Yii::t('events', 'User ID'),
        ];
    }

    public static function addProviderToUser($providerId,$userId=null)
    {
        if (is_null($userId)) {
            $userId = Yii::$app->getUser()->getId();
        }
        $model = new self();
        $model->provider_id = $providerId;
        $model->user_id = $userId;
        return $model->save();
    }

    /**
     * @inheritdoc
     * @return \app\modules\events\models\query\ProviderHasUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\events\models\query\ProviderHasUserQuery(get_called_class());
    }
}
