<?php

namespace app\commands;


use Yii;
use yii\console\Controller;

class InstallController extends Controller
{
    public function actionRun()
    {

        $auth = Yii::$app->authManager;

        $viewNewsIndex = $auth->createPermission('news.news.index');
        $viewNewsIndex->description = 'Просматривать список новосей';
        $auth->add($viewNewsIndex);

        $viewNewsView = $auth->createPermission('news.news.view');
        $viewNewsView->description = 'Просматривать полные новости';
        $auth->add($viewNewsView);

        $viewNewsCreate = $auth->createPermission('news.news.create');
        $viewNewsCreate->description = 'Добавлять новость';
        $auth->add($viewNewsCreate);

        $viewNewsUpdate = $auth->createPermission('news.news.update');
        $viewNewsUpdate->description = 'Обновить новость';
        $auth->add($viewNewsUpdate);

        $viewNewsDelete = $auth->createPermission('news.news.delete');
        $viewNewsDelete->description = 'Удалить новость';
        $auth->add($viewNewsDelete);

        // guest
        $guest = $auth->createRole('guest');
        $guest->description = 'Гость на сайте';
        $auth->add($guest);

        // user
        $user = $auth->createRole('user');
        $user->description = 'Пользователь на сайте';
        $auth->add($user);

        // moder
        $moder = $auth->createRole('moder');
        $moder->description = 'Модератор на сайте';
        $auth->add($moder);

        // admin
        $admin = $auth->createRole('admin');
        $admin->description = 'Админ на сайте';
        $auth->add($admin);

        $auth->addChild($guest,$viewNewsIndex);
        $auth->addChild($user,$viewNewsView);
        $auth->addChild($moder,$viewNewsCreate);
        $auth->addChild($moder,$viewNewsUpdate);
        $auth->addChild($moder,$viewNewsDelete);

        $auth->addChild($user,$guest);
        $auth->addChild($moder,$user);
        $auth->addChild($admin,$moder);


        $auth->assign($user, 3);
        $auth->assign($moder, 2);
        $auth->assign($admin, 1);

    }
}