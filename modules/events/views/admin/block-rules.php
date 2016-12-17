<?php

use yii\widgets\ActiveForm;

$allowFilesRules = Yii::$app->getModule('events')->getAliasOfFiles(Yii::$app->getModule('events')->pathRule);

$form = ActiveForm::begin();

echo '<div class="bs-callout bs-callout-info block-rules" index="'.$key.'">
        <button type="button" class="close" for="'.$model::className().'" relationId=""><span>×</span></button>';
echo $form->field($model, "[$key]event_id")->hiddenInput(['value'=>$eventId])->label(false);
echo $form->field($model, "[$key]name")->textInput();
echo $form->field($model, "[$key]class")->dropDownList(array_combine($allowFilesRules,$allowFilesRules));
echo $form->field($model, "[$key]data")->textarea()->hint("json array");
echo '</div>';