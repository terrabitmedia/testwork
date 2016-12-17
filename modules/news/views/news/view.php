<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\news\models\News */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('news', 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

        <?php if (Yii::$app->getUser()->can('news.news.create')) { ?>

            <?= Html::a(Yii::t('news', 'Create News'), ['create'], ['class' => 'btn btn-success', 'data-pjax' => 0]) ?>

        <?php } ?>

        <?php if (Yii::$app->getUser()->can('news.news.update')) { ?>

            <?= Html::a(Yii::t('news', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

        <?php } ?>

        <?php if (Yii::$app->getUser()->can('news.news.delete')) { ?>

            <?= Html::a(Yii::t('news', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('news', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>

        <?php } ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'author_id',
            //'short_text',
            'full_text:ntext',
            //'create_at',
            //'update_at',
        ],
    ]) ?>

</div>
