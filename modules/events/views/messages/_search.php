<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\events\models\search\MessagesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="messages-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'message_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'provider_id') ?>

    <?= $form->field($model, 'notice_id') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'text') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'from') ?>

    <?php // echo $form->field($model, 'to') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('events', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('events', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
