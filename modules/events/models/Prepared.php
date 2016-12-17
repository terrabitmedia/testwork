<?php

namespace app\modules\events\models;

use app\modules\events\components\behaviors\EmptyFieldJsonBehavior;
use app\modules\events\components\validators\JsonValidator;
use Yii;
use yii\base\Event;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%prepared}}".
 *
 * @property integer $prepared_id
 * @property integer $provider_id
 * @property integer $notice_id
 * @property string $attach
 * @property string $priority
 * @property string $status
 * @property string $data
 */
class Prepared extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%prepared}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => EmptyFieldJsonBehavior::className(),
                'attributes' => ['data']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['provider_id', 'notice_id'], 'integer'],
            [['attach', 'notice_id', 'provider_id'], 'required'],
            [['priority', 'status', 'data'], 'string'],
            [['attach'], 'string', 'max' => 64],
            [['data'],JsonValidator::className()],
            [['notice_id'], 'exist', 'skipOnError' => true, 'targetClass' => EventNotices::className(), 'targetAttribute' => ['notice_id' => 'notice_id']],
            [['provider_id'], 'exist', 'skipOnError' => true, 'targetClass' => EventProviders::className(), 'targetAttribute' => ['provider_id' => 'provider_id']],
        ];
    }

    public function getProvider()
    {
        return $this->hasOne(EventProviders::className(),['provider_id'=>'provider_id']);
    }

    public function getNotice()
    {
        return $this->hasOne(EventNotices::className(),['notice_id'=>'notice_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'prepared_id' => Yii::t('events', 'Prepared ID'),
            'provider_id' => Yii::t('events', 'Provider ID'),
            'notice_id' => Yii::t('events', 'Notice ID'),
            'attach' => Yii::t('events', 'Attach'),
            'priority' => Yii::t('events', 'Priority'),
            'status' => Yii::t('events', 'Status'),
            'data' => Yii::t('events', 'Data')
        ];
    }

    public function createNewPrepared(EventAssignment $assignment, Events $item, Event $event, $userId)
    {
        $model = new self();
        $model->provider_id = $assignment->provider_id;
        $model->notice_id = $item->notice_id;
        $model->attach = $assignment->attach;
        $model->priority = 'low';
        $model->status = 'wait';
        $model->data = Json::encode([
            'events_name' => $event->name,
            'model' => serialize($event->sender),
            'sub_data' => Json::encode($event->data),
            'user_id' => $userId
        ]);
        return $model->save();
    }

    public function getNewPreparedAndLock($priority)
    {
        $priority = in_array($priority,['low','high'])?$priority:'low';
        return array_map(function(Prepared $model) {
            $model->status = 'process';
            $model->save();
            return $model;
        }, self::find()->with(['provider','notice'])->where(['priority'=>$priority,'status'=>'wait'])->all());
    }

    /**
     * @inheritdoc
     * @return \app\modules\events\models\query\PreparedQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\events\models\query\PreparedQuery(get_called_class());
    }
}
