<?php

namespace app\modules\events\components\validators;


use Yii;
use yii\validators\Validator;

class JsonValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        if (json_decode($model->getAttribute($attribute))===NULL) {
            $this->addError($model,$attribute, Yii::t('events','Attribute {attribute} is not Json!',['attribute'=>$attribute]));
        }
    }
}