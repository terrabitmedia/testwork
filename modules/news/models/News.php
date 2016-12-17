<?php

namespace app\modules\news\models;

use Yii;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property integer $id
 * @property integer $author_id
 * @property string $short_text
 * @property string $full_text
 * @property integer $create_at
 * @property integer $update_at
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    public function behaviors()
    {
        return [
            'app\modules\news\components\behaviors\NewsBehavior'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id', 'create_at', 'update_at'], 'integer'],
            [['full_text'], 'required'],
            [['full_text','short_text'], 'string'],
            [['short_text'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('news', 'ID'),
            'author_id' => Yii::t('news', 'Author ID'),
            'short_text' => Yii::t('news', 'Short Text'),
            'full_text' => Yii::t('news', 'Full Text'),
            'create_at' => Yii::t('news', 'Create At'),
            'update_at' => Yii::t('news', 'Update At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \app\modules\news\models\query\NewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\news\models\query\NewsQuery(get_called_class());
    }
}
