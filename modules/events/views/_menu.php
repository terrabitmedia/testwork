<?php

use yii\bootstrap\Nav;

?>

<?= Nav::widget([
    'options' => [
        'class' => 'nav-tabs',
        'style' => 'margin-bottom: 15px',
    ],
    'items' => [
        [
            'label'   => Yii::t('events', 'List of events'),
            'url'     => ['/events/admin/index'],
        ],
        [
            'label'   => Yii::t('events', 'List of providers'),
            'url'     => ['/events/providers/index']
        ],
        [
            'label' => Yii::t('events', 'List of messages'),
            'url'   => ['/events/messages/index']
        ],
    ],
]) ?>
