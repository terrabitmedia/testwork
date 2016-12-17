<?php

class EventsCest
{

    public function createEventForm(\FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnRoute('/events/admin/create');
        $I->see('Create Events');
        $I->submitForm('div.events-form > form', [
            'Events[name]' => 'beforeUpdate',
            'Events[class]' => 'app\modules\news\models\News',
            'Events[description]' => 'test description',
            'EventNotices[name]' => 'Test notices',
            'EventNotices[class]' => 'app\modules\events\components\notices\StandardHandler',
            'EventNotices[title_template]' => 'Test template title',
            'EventNotices[template]' => 'Test template',
            'EventRules[0][name]' => 'Test rule',
            'EventRules[0][class]' => 'app\modules\events\components\rules\FakeRule',
            'EventAssignment[0][provider_id]' => '1',
            'EventAssignment[0][attach]' => 'self'
        ]);
        $I->see('test description','table.detail-view');
    }

    public function createProviderForm(\FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnRoute('/events/providers/create');
        $I->see('Create Event Providers');
        $I->submitForm('div.event-providers-form > form', [
            'EventProviders[name]' => 'test name',
            'EventProviders[class]' => 'app\modules\events\components\providers\Dialog',
        ]);
        $I->see('test name','table.detail-view');
    }

    public function createMessageNow(\FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnRoute('events/messages/send-messages');
        $I->see('Send messages now');
        $I->submitForm('div.panel-body > form', [
            'EventNotices[notice_id]' => null,
            'EventNotices[name]' => 'Test notice for message now',
            'EventNotices[class]' => 'app\modules\events\components\notices\StandardHandler',
            'EventNotices[title_template]' => 'test title template',
            'EventNotices[template]' => 'test template',
            'EventNotices[data]' => '',
            'Prepared[0][provider_id]' => '1',
            'Prepared[0][attach]' => 'admin'
        ]);
        $I->see('All posts sent.','div');
    }
}