<?php

namespace app\modules\events\components\notices;


use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class AdvancedHandler extends StandardHandler
{

    public $url = null;

    public $parametersUrl = [];

    public $useCreateUrl = true;

    public $maskUrl = null;

    public function processData(Model $model, Model $user, $template, $title_template)
    {
        parent::processData($model, $user, $template, $title_template);

        if ($this->useCreateUrl) {
            $this->url = Url::to(ArrayHelper::merge([$this->url],$model->getAttributes($this->parametersUrl)));
        }

        $this->title = str_replace($this->maskUrl,'<a href="'.$this->url.'">'.$this->url.'</a>',$this->title);

        $this->text = str_replace($this->maskUrl,'<a href="'.$this->url.'">'.$this->url.'</a>',$this->text);

    }

}