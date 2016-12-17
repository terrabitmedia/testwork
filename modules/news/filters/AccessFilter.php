<?php

namespace app\modules\news\filters;


use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;

class AccessFilter extends ActionFilter
{
    public $controllers = [];
    public $condition = null;

    public function beforeAction($action)
    {

        if ($this->condition instanceof \Closure && call_user_func_array($this->condition,[$action])) {
            return true;
        }

        if (!\Yii::$app->getUser()->getIsGuest() && \Yii::$app->getUser()->getIdentity()->getIsAdmin()) {
            return true;
        }

        $module = $action->controller->module;

        if ($module) {
            $module = $module->id.".";
        }

        $urlArray = [
            $module.$action->controller->id.".".$action->id,
            $module.$action->controller->id.".*",
            $module."*"
        ];

        if ((bool)array_intersect($urlArray,$this->controllers)) {
            return true;
        }

        foreach ($urlArray as $itemUrl) {
            if (\Yii::$app->getUser()->can($itemUrl)) {
                return true;
            }
        }

        throw new ForbiddenHttpException(\Yii::t('news', 'Access denied!'));

    }
}