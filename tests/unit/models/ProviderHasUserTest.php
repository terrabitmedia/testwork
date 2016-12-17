<?php

namespace tests\models;


use app\modules\events\models\ProviderHasUser;

class ProviderHasUserTest extends \Codeception\Test\Unit
{
    public function testAddProviderToUser()
    {
        expect(\Yii::$container->get(ProviderHasUser::className())->addProviderToUser(1,1))->true();
    }
}