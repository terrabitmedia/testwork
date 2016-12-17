<?php

use yii\widgets\ActiveForm;

$dropDownListProvider = \yii\helpers\ArrayHelper::map(\app\modules\events\models\EventProviders::find()->all(),'provider_id','name');
$dropDownListRoles = \app\modules\events\components\Tools::getAllowUsers(['self'],['guest']);

$form = ActiveForm::begin();

echo '<div class="bs-callout bs-callout-info block-assignments" index="'.$key.'">
        <button type="button" class="close" for="'.$model::className().'" relationId=""><span>×</span></button>';
echo $form->field($model, "[$key]event_id")->hiddenInput(['value'=>$eventId])->label(false);
echo $form->field($model, "[$key]provider_id")->dropDownList($dropDownListProvider);
echo $form->field($model, "[$key]attach")->dropDownList(array_combine($dropDownListRoles,$dropDownListRoles));
echo '</div>';