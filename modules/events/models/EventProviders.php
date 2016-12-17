<?php

namespace app\modules\events\models;

use app\modules\events\components\behaviors\EmptyFieldJsonBehavior;
use app\modules\events\components\validators\JsonValidator;
use Yii;

/**
 * This is the model class for table "{{%event_providers}}".
 *
 * @property integer $provider_id
 * @property string $name
 * @property string $class
 * @property string $data
 */
class EventProviders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%event_providers}}';
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
            'provider_id' => Yii::t('events', 'Provider ID'),
            'name' => Yii::t('events', 'Name'),
            'class' => Yii::t('events', 'Class'),
            'data' => Yii::t('events', 'Data'),
        ];
    }

    public function getProviderByClass($class)
    {
        return self::find()->where(['class'=>$class])->one();
    }

    /**
     * @inheritdoc
     * @return \app\modules\events\models\query\EventProvidersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\events\models\query\EventProvidersQuery(get_called_class());
    }
}
