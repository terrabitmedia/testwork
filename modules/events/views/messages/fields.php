<?php

use yii\widgets\ActiveForm;

$dropDownListProvider = \yii\helpers\ArrayHelper::map(\app\modules\events\models\EventProviders::find()->all(),'provider_id','name');
$dropDownListRoles = \app\modules\events\components\Tools::getAllowUsers([],['guest']);

echo '<div class="bs-callout bs-callout-info block-user-provider" index="'.$key.'">
        <button type="button" class="close"><span>×</span></button>';
    $form = ActiveForm::begin(['enableClientValidation'=>false]);
    echo $form->field($model, "[$key]provider_id")->dropDownList($dropDownListProvider);
    echo $form->field($model, "[$key]attach")->dropDownList(array_combine($dropDownListRoles,$dropDownListRoles));
echo '</div>';
