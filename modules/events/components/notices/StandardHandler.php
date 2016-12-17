<?php

namespace app\modules\events\components\notices;


use app\modules\events\components\InterfaceNoticeHandler;
use yii\base\Model;
use yii\base\Object;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

class StandardHandler extends Object implements InterfaceNoticeHandler
{

    public $maskReplaceField = '{{field}}';

    public $useHtmlSpecialChars = true;

    public $replaceFields = [];

    protected $text = null;

    protected $title = null;

    public function processData(Model $model, Model $user, $template, $title_template)
    {

        $replaceField = [];

        $closureHeader = function($item, $key, $table) use (&$replaceField) {
            if ($this->useHtmlSpecialChars) {
                $item = htmlspecialchars($item);
            }
            $key = str_replace('field',$table.'.'.$key,$this->maskReplaceField);
            $replaceField[$key] = $item;
        };
        $closureHeader->bindTo($this);

        if ($model::className()!=$user::className()) {
            $attributes = $user->getAttributes();
            array_walk($attributes, $closureHeader, 'user');
        }

        $attributes = $model->getAttributes();
        array_walk($attributes, $closureHeader, Inflector::camel2id(StringHelper::basename($model::className()), '_'));

        unset($attributes);

        $this->replaceFields = ArrayHelper::merge($replaceField,$this->replaceFields);

        $this->text = str_ireplace(array_keys($this->replaceFields),array_values($this->replaceFields),$template);

        $this->title = str_ireplace(array_keys($this->replaceFields),array_values($this->replaceFields),$title_template);

    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getText()
    {
        return $this->text;
    }
}