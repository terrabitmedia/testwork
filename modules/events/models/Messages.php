<?php

namespace app\modules\events\models;

use app\modules\events\components\InterfaceMessage;
use Yii;

/**
 * This is the model class for table "{{%messages}}".
 *
 * @property integer $message_id
 * @property integer $user_id
 * @property integer $provider_id
 * @property integer $notice_id
 * @property string $status
 * @property string $text
 * @property string $title
 * @property string $from
 * @property string $to
 */
class Messages extends \yii\db\ActiveRecord
{

    const CONST_STATUS_DONE = 'done';
    const CONST_STATUS_WAIT = 'wait';
    const CONST_STATUS_ERROR = 'error';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%messages}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'provider_id', 'notice_id'], 'integer'],
            [['status', 'text', 'title'], 'string'],
            [['from', 'to'], 'string', 'max' => 255],
            [['notice_id'], 'exist', 'skipOnError' => true, 'targetClass' => EventNotices::className(), 'targetAttribute' => ['notice_id' => 'notice_id']],
            [['provider_id'], 'exist', 'skipOnError' => true, 'targetClass' => EventProviders::className(), 'targetAttribute' => ['provider_id' => 'provider_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'message_id' => Yii::t('events', 'Message ID'),
            'user_id' => Yii::t('events', 'User ID'),
            'provider_id' => Yii::t('events', 'Provider ID'),
            'notice_id' => Yii::t('events', 'Notice ID'),
            'status' => Yii::t('events', 'Status'),
            'text' => Yii::t('events', 'Text'),
            'title' => Yii::t('events', 'Title'),
            'from' => Yii::t('events', 'From'),
            'to' => Yii::t('events', 'To')
        ];
    }

    public function getNewMessageAndDone($provider_id,$user_id)
    {
        $modelMessage = self::find()->where([
            'provider_id' => $provider_id,
            'user_id' => $user_id,
            'status' => self::CONST_STATUS_WAIT
        ])->orderBy('message_id ASC')->one();
        if ($modelMessage) {
            $modelMessage->status = self::CONST_STATUS_DONE;
            $modelMessage->save();
        }
        return $modelMessage;
    }

    public function createNewMessage(InterfaceMessage $message)
    {
        $modelMessage = new self();
        $modelMessage->user_id = $message->getUserId();
        $modelMessage->provider_id = $message->getProviderId();
        $modelMessage->notice_id = $message->getNoticeId();
        $modelMessage->status = $message->getStatus();
        $modelMessage->title = $message->getTitle();
        $modelMessage->text = $message->getText();
        $modelMessage->from = $message->getFrom();
        $modelMessage->to = $message->getTo();
        return $modelMessage->save();
    }

    /**
     * @inheritdoc
     * @return \app\modules\events\models\query\MessagesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\events\models\query\MessagesQuery(get_called_class());
    }
}
