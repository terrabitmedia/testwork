<?php

namespace app\modules\events\components;


use yii\base\Model;

interface InterfaceNoticeHandler
{
    public function getText();
    public function getTitle();
    public function processData(Model $model, Model $user, $template, $title_template);
}