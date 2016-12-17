<?php

namespace tests\components;


use app\modules\events\components\notices\AdvancedHandler;
use app\modules\events\components\notices\StandardHandler;
use app\modules\news\models\News;
use app\modules\users\models\User;
use yii\base\Model;

class HandlerTest extends \Codeception\Test\Unit
{
    public function testStandardHandler()
    {
        $handler = new StandardHandler([
            'replaceFields' => [
                '{{replace}}' => 'super'
            ]
        ]);
        $handler->processData(
            new Model(),
            User::findIdentity(1),
            'Text {{user.username}} text replace {{replace}}',
            'Title {{user.username}} title replace {{replace}}'
        );
        $this->assertEquals('Text admin text replace super',$handler->getText());
        $this->assertEquals('Title admin title replace super',$handler->getTitle());
    }

    public function testAdvancedHandler()
    {
        $handler = new AdvancedHandler([
            'replaceFields' => [
                '{{replace}}' => 'super'
            ],
            'maskUrl' => '//url//',
            'url' => '/news/news/view',
            'parametersUrl' => ['id']
        ]);
        $handler->processData(
            News::findOne(1),
            User::findIdentity(1),
            'Text {{user.username}} text replace {{replace}} //url//',
            'Title {{user.username}} title replace {{replace}} //url//'
        );
        $this->assertEquals('Text admin text replace super <a href="/index-test.php?r=news%2Fnews%2Fview&id=1">/index-test.php?r=news%2Fnews%2Fview&id=1</a>',$handler->getText());
        $this->assertEquals('Title admin title replace super <a href="/index-test.php?r=news%2Fnews%2Fview&id=1">/index-test.php?r=news%2Fnews%2Fview&id=1</a>',$handler->getTitle());
    }
}