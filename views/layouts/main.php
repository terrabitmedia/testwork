<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        [
            'label' => 'List of news',
            'url' => ['/news/news/index']
        ],
        [
            'label' => 'Administration',
            'url' => ['/user/admin/index'],
            'visible' => Yii::$app->extensions['dektrium/yii2-user'] && !Yii::$app->user->isGuest && Yii::$app->getUser()->getIdentity()->getIsAdmin()
        ],
        [
            'label' => 'Events',
            'url' => ['/events/admin/index'],
            'visible' => Yii::$app->hasModule('events') && !Yii::$app->user->isGuest && Yii::$app->getUser()->getIdentity()->getIsAdmin()
        ],
        [
            'label' => 'Profile',
            'url' => ['/user/settings/profile'],
            'visible' => Yii::$app->extensions['dektrium/yii2-user'] && !Yii::$app->user->isGuest
        ],
        [
            'label' => 'Sign in',
            'url' => ['/user/security/login'],
            'visible' => Yii::$app->extensions['dektrium/yii2-user'] && Yii::$app->user->isGuest
        ],
        [
            'label' => 'Sign up',
            'url' => ['/user/registration/register'],
            'visible' => Yii::$app->extensions['dektrium/yii2-user'] && Yii::$app->user->isGuest
        ],
    ];
    if (Yii::$app->extensions['dektrium/yii2-user'] && !Yii::$app->user->isGuest) {
        $menuItems[] = '<li>'
            . Html::beginForm(['/user/security/logout'], 'post',['id'=>'logoutForm'])
            . Html::submitButton(
                'Sign out ('.Yii::$app->user->identity['username'].')', [
                    'class' => 'btn btn-link',
                    'style' => 'padding-top: 15px;padding-bottom: 15px;'
                ]
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left"><?=Yii::$app->name;?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
