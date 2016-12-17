<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\modules\events\models\Messages */

$dropDownListProvider = \yii\helpers\ArrayHelper::map(\app\modules\events\models\EventProviders::find()->all(),'provider_id','name');
$dropDownListRoles = \app\modules\events\components\Tools::getAllowUsers([],['guest']);

$this->title = Yii::t('events', 'Send messages now');
$this->params['breadcrumbs'][] = ['label' => Yii::t('events', 'Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs('$(document).on("click",".bs-callout > .close",function(e) { $(this).parent().remove(); });');
$this->registerJs('$(document).on("click",".add_user_provider",function(e) { var elementName = $(this).attr("for"); var wrapper = $(this).attr("wrapper"); var elementLength = parseInt($("."+elementName+":last").attr("index")); console.log(); if (isNaN(elementLength)) { elementLength=0; } else { elementLength=elementLength+1; } $.get("'.\yii\helpers\Url::to(['fields']).'",{key:elementLength}).done(function(data){ $("."+wrapper).append(data); }); });');

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

<?= $this->render('/_menu') ?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">

                <?php $form = ActiveForm::begin(['enableClientValidation'=>false]); ?>

                <h2><?=Yii::t('events','Create Message Handler');?></h2>

                <hr>

                <?= $form->errorSummary($modelNotice); ?>

                <?= $form->field($modelNotice, 'notice_id')->hiddenInput()->label(false) ?>

                <?= $form->field($modelNotice, 'name')->textInput() ?>

                <?php $allowFilesNotices = Yii::$app->getModule('events')->getAliasOfFiles(Yii::$app->getModule('events')->pathNotices); ?>
                <?= $form->field($modelNotice, 'class')->dropDownList(array_combine($allowFilesNotices,$allowFilesNotices)) ?>

                <?= $form->field($modelNotice, 'title_template')->textarea(['rows' => 6])
                    ->hint("Examples templates: {{user.username}},{{table.field}} and others") ?>

                <?= $form->field($modelNotice, 'template')->textarea(['rows' => 6])
                    ->hint("Examples templates: {{user.username}},{{table.field}} and others") ?>

                <?= $form->field($modelNotice, 'data')->textarea(['rows' => 6])
                    ->hint("json array") ?>

                <h2><?=Yii::t('events','Add users and providers'); ?></h2>

                <hr>

                <div class="wrapper-prepared">

                    <?php foreach ($modelPrepared as $key => $itemPrepared) { ?>

                        <div class="bs-callout bs-callout-info block-user-provider" index="<?= $key;?>">
                            <button type="button" class="close"><span>×</span></button>

                        <?= $form->errorSummary($itemPrepared); ?>

                        <?= $form->field($itemPrepared, "[$key]provider_id")->dropDownList($dropDownListProvider); ?>

                        <?= $form->field($itemPrepared, "[$key]attach")->dropDownList(array_combine($dropDownListRoles,$dropDownListRoles)); ?>

                        </div>

                    <?php } ?>

                </div>

                <?=Html::a(Yii::t('events','Add new user and provider'),'javascript:void(0)',[
                    'class'=>'add_user_provider btn btn-info',
                    'wrapper' => 'wrapper-prepared',
                    'for' => 'block-user-provider'
                ]); ?>

                <div class="form-group" style="margin-top: 30px">
                    <?= Html::submitButton(Yii::t('events', 'Create'), ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
