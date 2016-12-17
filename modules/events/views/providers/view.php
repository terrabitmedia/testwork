<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\events\models\EventProviders */

$this->title = $model->name;
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
                <p>
                    <?= Html::a(Yii::t('events', 'Update'), ['update', 'id' => $model->provider_id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('events', 'Delete'), ['delete', 'id' => $model->provider_id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('events', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'provider_id',
                        'name',
                        'class',
                        'data:ntext',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
