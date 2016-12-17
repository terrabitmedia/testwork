<?php
use yii\bootstrap\Html;
use yii\widgets\DetailView;
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= $model->class.' ['.$model->name.']';?>
            </div>
            <div class="panel-body">
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
                <?php
                echo Html::a(
                    Yii::t('events','Read more'),
                    ['view', 'id' => $model->event_id],
                    ['class' => 'btn btn-info', 'data-pjax' => 0]
                );
                echo Html::a(
                    Yii::t('events','Update'),
                    ['update', 'id' => $model->event_id],
                    ['class' => 'btn btn-primary', 'data-pjax' => 0]
                );
                echo Html::a(Yii::t('events', 'Delete'), ['delete', 'id' => $model->event_id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('news', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
</div>