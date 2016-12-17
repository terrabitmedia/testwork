<?php

namespace app\modules\events\models;

use Yii;

/**
 * This is the model class for table "{{%events}}".
 *
 * @property integer $event_id
 * @property integer $notice_id
 * @property string $name
 * @property string $class
 * @property string $description
 */
class Events extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%events}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notice_id'], 'integer'],
            [['name', 'class'], 'required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['class'], 'string', 'max' => 512],
            [['notice_id'], 'exist', 'skipOnError' => true, 'targetClass' => EventNotices::className(), 'targetAttribute' => ['notice_id' => 'notice_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'event_id' => Yii::t('events', 'Event ID'),
            'notice_id' => Yii::t('events', 'Notice ID'),
            'name' => Yii::t('events', 'Name'),
            'class' => Yii::t('events', 'Class'),
            'description' => Yii::t('events', 'Description'),
        ];
    }

    public function getEventRules()
    {
        return $this->hasMany(EventRules::className(),['event_id'=>'event_id']);
    }

    public function getAssignment()
    {
        return $this->hasMany(EventAssignment::className(),['event_id'=>'event_id']);
    }

    public function getNotice()
    {
        return $this->hasOne(EventNotices::className(),['notice_id'=>'notice_id']);
    }

    public function getAllEventsGroupBy()
    {
        return self::find()->groupBy(['class','name'])->all();
    }

    public function getEventsByNameAndClass($name, $class)
    {
        return self::find()->with(['eventRules','assignment','notice'])
            ->where(['class'=>$class,'name'=>$name])->all();
    }

    /**
     * @inheritdoc
     * @return \app\modules\events\models\query\EventsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\events\models\query\EventsQuery(get_called_class());
    }
}
