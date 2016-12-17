<?php

namespace app\modules\events\models;

use Yii;

/**
 * This is the model class for table "{{%event_assignment}}".
 *
 * @property integer $id
 * @property integer $event_id
 * @property integer $provider_id
 * @property string $attach
 */
class EventAssignment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%event_assignment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'provider_id'], 'integer'],
            [['attach'], 'required'],
            [['attach'], 'string', 'max' => 64],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Events::className(), 'targetAttribute' => ['event_id' => 'event_id']],
            [['provider_id'], 'exist', 'skipOnError' => true, 'targetClass' => EventProviders::className(), 'targetAttribute' => ['provider_id' => 'provider_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('events', 'ID'),
            'event_id' => Yii::t('events', 'Event ID'),
            'provider_id' => Yii::t('events', 'Provider ID'),
            'attach' => Yii::t('events', 'Attach users'),
        ];
    }

    public function getProvider()
    {
        return $this->hasOne(EventProviders::className(),['provider_id'=>'provider_id']);
    }

    /**
     * @inheritdoc
     * @return \app\modules\events\models\query\EventAssignmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\events\models\query\EventAssignmentQuery(get_called_class());
    }
}
