<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\events\models\EventProviders */

$this->title = Yii::t('events', 'Create Event Providers');
$this->params['breadcrumbs'][] = ['label' => Yii::t('events', 'Event Providers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


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
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>