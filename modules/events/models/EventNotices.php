<?php

namespace app\modules\events\models;

use app\modules\events\components\behaviors\EmptyFieldJsonBehavior;
use app\modules\events\components\validators\JsonValidator;
use Yii;

/**
 * This is the model class for table "{{%event_notices}}".
 *
 * @property integer $notice_id
 * @property string $name
 * @property string $class
 * @property string $title_template
 * @property string $template
 * @property string $data
 */
class EventNotices extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%event_notices}}';
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
            [['name', 'class'], 'required'],
            [['template', 'title_template', 'data'], 'string'],
            [['data'],JsonValidator::className()],
            [['name'], 'string', 'max' => 255],
            [['class'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'notice_id' => Yii::t('events', 'Notice ID'),
            'name' => Yii::t('events', 'Name of notices'),
            'class' => Yii::t('events', 'Class'),
            'title_template' => Yii::t('events', 'Title template'),
            'template' => Yii::t('events', 'Template'),
            'data' => Yii::t('events', 'Data'),
        ];
    }

    /**
     * @inheritdoc
     * @return \app\modules\events\models\query\EventNoticesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\events\models\query\EventNoticesQuery(get_called_class());
    }
}
