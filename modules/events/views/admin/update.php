<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\events\models\Events */

$this->title = Yii::t('events', 'Update {modelClass}: ', [
    'modelClass' => 'Events',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('events', 'Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->event_id]];
$this->params['breadcrumbs'][] = Yii::t('events', 'Update');
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
                    'modelNotices' => $modelNotices,
                    'modelRules' => $modelRules,
                    'modelAssignment' => $modelAssignment
                ]) ?>
            </div>
        </div>
    </div>
</div>