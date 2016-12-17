<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\events\models\search\EventProvidersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-providers-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'provider_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'class') ?>

    <?= $form->field($model, 'data') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('events', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('events', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
