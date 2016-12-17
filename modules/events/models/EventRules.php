<?php

namespace app\modules\events\models;

use app\modules\events\components\behaviors\EmptyFieldJsonBehavior;
use app\modules\events\components\validators\JsonValidator;
use Yii;

/**
 * This is the model class for table "{{%event_rules}}".
 *
 * @property integer $rule_id
 * @property integer $event_id
 * @property string $name
 * @property string $class
 * @property string $data
 */
class EventRules extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%event_rules}}';
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
            [['event_id'], 'integer'],
            [['name', 'class', 'event_id'], 'required'],
            [['data'], 'string'],
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
            'rule_id' => Yii::t('events', 'Rule ID'),
            'event_id' => Yii::t('events', 'Event ID'),
            'name' => Yii::t('events', 'Name of rules'),
            'class' => Yii::t('events', 'Class'),
            'data' => Yii::t('events', 'Data'),
        ];
    }

    /**
     * @inheritdoc
     * @return \app\modules\events\models\query\EventRulesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\events\models\query\EventRulesQuery(get_called_class());
    }
}
