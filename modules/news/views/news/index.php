<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\news\models\search\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('news', 'News');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // $this->render('_search', ['model' => $searchModel]); ?>

    <?php if (Yii::$app->getUser()->can('news.news.create')) { ?>

        <p><?= Html::a(Yii::t('news', 'Create News'), ['create'], ['class' => 'btn btn-success', 'data-pjax' => 0]) ?></p>

    <?php } ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{summary}\n<div class='clearfix'>{pager}</div>\n<div class='clearfix'>{items}</div>\n<div class='clearfix'>{pager}</div>",
        'itemOptions' => ['class' => 'item'],
        'itemView' => function (\app\modules\news\models\News $model, $key, $index, $widget) {
            $text = '<div style="margin-top: 10px;padding-top:10px;border-top: 2px solid #337ab7;"><p>'.Html::encode($model->short_text).'</p></div>';
            if (Yii::$app->getUser()->can('news.news.view')) {
                $text .= Html::a(
                        Yii::t('news','Read more'),
                        ['view', 'id' => $model->id],
                        ['class' => 'btn btn-info', 'data-pjax' => 0]
                );
            }
            if (Yii::$app->getUser()->can('news.news.update')) {
                $text .= Html::a(
                    Yii::t('news','Update'),
                    ['update', 'id' => $model->id],
                    ['class' => 'btn btn-primary', 'data-pjax' => 0]
                );
            }
            if (Yii::$app->getUser()->can('news.news.delete')) {
                $text .= Html::a(Yii::t('news', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('news', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]);
            }
            return $text;
        },
        'pager' => [
            'class' => \app\modules\news\widgets\advancedpager\AdvancedLinkPager::className(),
            'firstPageLabel' => 'First',
            'lastPageLabel' => 'Last',
            'maxButtonCount' => 4,
            'options' => [
                'class' => 'pagination',
                'style' => 'display:inline-block;float:left;margin:20px 10px 20px 0;width:auto;'
            ],
            'sizeListHtmlOptions' => [
                'class' => 'form-control',
                'style' => 'display:inline-block;float:left;margin:20px 10px 20px 0;width:auto;'
            ],
            'goToPageHtmlOptions' => [
                'class' => 'form-control',
                'style' => 'display:inline-block;float:left;margin:20px 10px 20px 0;width:auto;'
            ],
        ]
    ]) ?>
    <?php Pjax::end(); ?>
</div>
