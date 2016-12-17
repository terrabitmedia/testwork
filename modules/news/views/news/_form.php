<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\news\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model, 'author_id')->textInput() ?>

    <?php // $form->field($model, 'short_text')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'full_text')->textarea(['rows' => 6]) ?>

    <?php // $form->field($model, 'create_at')->textInput() ?>

    <?php // $form->field($model, 'update_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('news', 'Create') : Yii::t('news', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
