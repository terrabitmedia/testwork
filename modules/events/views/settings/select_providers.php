<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this  yii\web\View
 * @var $form  yii\widgets\ActiveForm
 * @var $model dektrium\user\models\SettingsForm
 */

$this->title = Yii::t('user', 'Select providers');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
    if (Yii::$app->getSession()->hasFlash('providers_saved')) {
        echo \yii\bootstrap\Alert::widget([
            'options' => [
                'class' => 'alert-success',
            ],
            'body' => Yii::$app->getSession()->getFlash('providers_saved')[0]]);
    }
?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id'          => 'select-providers-form',
                    'options'     => ['class' => 'form-horizontal'],
                    'fieldConfig' => [
                        'template'     => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
                        'labelOptions' => ['class' => 'col-lg-3 control-label'],
                    ],
                ]); ?>

                <?= $form->field($model, 'providers')->checkboxList(\yii\helpers\ArrayHelper::map(\app\modules\events\models\EventProviders::find()->all(),'provider_id','name')); ?>

                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <?= Html::submitButton(Yii::t('events', 'Save'), ['class' => 'btn btn-block btn-success']) ?><br>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>
</div>
