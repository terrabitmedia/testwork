<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\events\models\Events */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('events', 'Events'), 'url' => ['index']];
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
                    <?= Html::a(Yii::t('events', 'Update'), ['update', 'id' => $model->event_id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('events', 'Delete'), ['delete', 'id' => $model->event_id], [
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
                        'event_id',
                        'name',
                        'class',
                        'description:ntext',
                        [
                            'label' => $model->getAttributeLabel('eventRules.name'),
                            'format'=> 'raw',
                            'value' => function($model) {
                                $rules = '';
                                foreach ($model->eventRules as $item) {
                                    $rules .= '<span class="label label-default">'.$item['name'].'</span><br>';
                                }
                                return $rules;
                            },
                        ],
                        [
                            'label' => $model->getAttributeLabel('assignment.attach'),
                            'format'=> 'raw',
                            'value' => function($model) {
                                $attach = '';
                                foreach ($model->assignment as $item) {
                                    $attach .= '<span class="label label-default">'.$item['provider']['name'].' : '.$item['attach'].'</span><br>';
                                }
                                return $attach;
                            },
                        ],
                        [
                            'label' => $model->getAttributeLabel('notice.name'),
                            'format'=> 'raw',
                            'value' => function($model) {
                                return $model->notice['name'];
                            },
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>