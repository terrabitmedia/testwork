<?php

namespace tests\components;

use app\modules\events\components\Tools;
use yii\base\Object;

class ToolsTest extends \Codeception\Test\Unit
{
    public function testArrayPad()
    {
        $this->assertEquals([new Object(),new Object(),new Object(),new Object()],Tools::array_pad([],4,new Object()));
    }

    public function testResetKeysArray()
    {
        $this->assertEquals(['key'=>['a','b','c']],Tools::reset_keys_array(['key'=>[1=>'a',3=>'b',6=>'c']],'key'));
    }

    public function testGetAllowUsers()
    {
        $this->assertEquals(['self','admin','guest','moder','user'],Tools::getAllowUsers(['self']));
        $this->assertEquals(['self','admin','guest','moder'],Tools::getAllowUsers(['self'],['user']));
    }

}