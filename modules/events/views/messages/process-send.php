<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\events\models\Events */

$this->title = Yii::t('events', 'Send messages now');
$this->params['breadcrumbs'][] = ['label' => Yii::t('events', 'Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<style>
    .bs-callout-info {
        border-left-color: #1b809e;
    }
    .bs-callout {
        padding: 20px;
        margin: 20px 0;
        border: 1px solid #eee;
        border-left-width: 5px;
        border-radius: 3px;
    }
</style>

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
                <div class="bs-callout bs-callout-info">
                    <?php if ($result==0) { ?>
                        <?= $output; ?>
                    <?php } else { ?>
                        <?= Yii::t('events','There is an error. You must say about it your god.'); ?>
                        <br>
                        <?= $output; ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>