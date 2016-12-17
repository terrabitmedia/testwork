<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\widgets\Menu;

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?=Yii::t('events','Menu');?></h3>
    </div>
    <div class="panel-body">
        <?= Menu::widget([
            'options' => [
                'class' => 'nav nav-pills nav-stacked',
            ],
            'items' => [
                ['label' => Yii::t('user', 'List'), 'url' => ['/events/providers/index']],
                ['label' => Yii::t('user', 'Create'), 'url' => ['/events/providers/create']],
            ],
        ]) ?>
    </div>
</div>
