<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\events\models\Events */
/* @var $form yii\widgets\ActiveForm */

$allowFilesRules = Yii::$app->getModule('events')->getAliasOfFiles(Yii::$app->getModule('events')->pathRule);
$dropDownListProvider = \yii\helpers\ArrayHelper::map(\app\modules\events\models\EventProviders::find()->all(),'provider_id','name');
$dropDownListRoles = \app\modules\events\components\Tools::getAllowUsers(['self'],['guest']);

$this->registerJs('$(document).on("click",".bs-callout > .close",function(e) { var element = this; var modelClass = $(this).attr("for"); var relationId = $(this).attr("relationId"); if (modelClass=="" || relationId=="") { $(element).parent().remove(); return false; } $.get("'.\yii\helpers\Url::to(['delete-relation']).'",{modelClass:modelClass,relationId:relationId}).done(function(data) { if (data.response=="successful") {$(element).parent().remove();} else {alert("There is an error!");} }); });');
$this->registerJs('$(document).on("click",".add_rule,.add_assignment",function(e) { var elementName = $(this).attr("for"); var wrapper = $(this).attr("wrapper"); var elementLength = parseInt($("."+elementName+":last").attr("index")); if (isNaN(elementLength)) { elementLength=0; } else { elementLength=elementLength+1; } var eventId = $(this).attr("event_id")?$(this).attr("event_id"):""; $.get("'.\yii\helpers\Url::to(['fields']).'",{key:elementLength,modelClass:$(this).attr("model"),view:elementName,eventId:eventId}).done(function(data){ $("."+wrapper).append(data); }); });');

?>

<style>
    .bs-callout-info {
        border-left-color: #1b809e;
    }
    .bs-callout {
        padding: 20px;
        margin: 20px 0;
        border: 1px solid #eee;
        border-left-width: 5px;
        border-radius: 3px;
    }
</style>

<div class="events-form">

    <?php $form = ActiveForm::begin(['enableClientValidation'=>false]); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'event_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'notice_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'name')->dropDownList(array_combine(Yii::$app->getModule('events')->listenEvents,Yii::$app->getModule('events')->listenEvents)) ?>

    <?php $allowFilesModels = Yii::$app->getModule('events')->scanAllModels(); ?>
    <?= $form->field($model, 'class')->dropDownList(array_combine($allowFilesModels,$allowFilesModels)) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <h2><?=Yii::t('events','Create Message Handler');?></h2>

    <hr>

    <?= $form->errorSummary($modelNotices); ?>

    <?= $form->field($modelNotices, 'notice_id')->hiddenInput()->label(false) ?>

    <?= $form->field($modelNotices, 'name')->textInput() ?>

    <?php $allowFilesNotices = Yii::$app->getModule('events')->getAliasOfFiles(Yii::$app->getModule('events')->pathNotices); ?>
    <?= $form->field($modelNotices, 'class')->dropDownList(array_combine($allowFilesNotices,$allowFilesNotices)) ?>

    <?= $form->field($modelNotices, 'title_template')->textarea(['rows' => 6])
        ->hint("Examples templates: {{user.username}},{{table.field}} and others") ?>

    <?= $form->field($modelNotices, 'template')->textarea(['rows' => 6])
        ->hint("Examples templates: {{user.username}},{{table.field}} and others") ?>

    <?= $form->field($modelNotices, 'data')->textarea(['rows' => 6])
        ->hint("json array") ?>

    <h2><?=Yii::t('events','Create Rules');?></h2>

    <hr>

    <?php

        echo '<div class="wrapper-rules">';

        foreach ($modelRules as $key => $modelRule) {
            echo '<div class="bs-callout bs-callout-info block-rules" index="'.$key.'">
                    <button type="button" class="close" for="'.\app\modules\events\models\EventRules::className().'" relationId="'.$modelRule->rule_id.'"><span>×</span></button>';
            echo $form->errorSummary($modelRule);
            echo $form->field($modelRule, "[$key]rule_id")->hiddenInput()->label(false);
            echo $form->field($modelRule, "[$key]event_id")->hiddenInput()->label(false);
            echo $form->field($modelRule, "[$key]name")->textInput();
            echo $form->field($modelRule, "[$key]class")->dropDownList(array_combine($allowFilesRules,$allowFilesRules));
            echo $form->field($modelRule, "[$key]data")->textarea()->hint("json array");
            echo '</div>';
        }

        echo '</div>';

        echo Html::a(Yii::t('events','Add rule'),'javascript:void(0)',[
            'class'=>'add_rule btn btn-info',
            'for'=>'block-rules',
            'wrapper'=>'wrapper-rules',
            'model' => \app\modules\events\models\EventRules::className(),
            'event_id' => $model->event_id
        ]);

    ?>

    <h2><?=Yii::t('events','Attach the user and the provider');?></h2>

    <hr>

    <?php

    echo '<div class="wrapper-assignments">';

    foreach ($modelAssignment as $key => $assignment) {
        echo '<div class="bs-callout bs-callout-info block-assignments" index="'.$key.'">
                <button type="button" class="close" for="'.\app\modules\events\models\EventAssignment::className().'" relationId="'.$assignment->id.'"><span>×</span></button>';
        echo $form->errorSummary($assignment);
        echo $form->field($assignment, "[$key]id")->hiddenInput()->label(false);
        echo $form->field($assignment, "[$key]event_id")->hiddenInput()->label(false);
        echo $form->field($assignment, "[$key]provider_id")->dropDownList($dropDownListProvider);
        echo $form->field($assignment, "[$key]attach")->dropDownList(array_combine($dropDownListRoles,$dropDownListRoles));
        echo '</div>';
    }

    echo '</div>';

    echo Html::a(Yii::t('events','Add assignment'),'javascript:void(0)',[
        'class'=>'add_assignment btn btn-info',
        'for'=>'block-assignments',
        'wrapper'=>'wrapper-assignments',
        'model' => \app\modules\events\models\EventAssignment::className(),
        'event_id' => $model->event_id
    ]);

    ?>

    <div class="form-group" style="margin-top: 30px">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('events', 'Create') : Yii::t('events', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
