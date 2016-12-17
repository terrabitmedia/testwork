<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\events\models\search\EventProvidersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('events', 'Event Providers');
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
                <?php Pjax::begin(); ?>
                <?php echo $this->render('_search', ['model' => $searchModel]); ?>

                <p>
                    <?= Html::a(Yii::t('events', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
                </p>
                <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'provider_id',
                            'name',
                            'class',
                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>