<?php

class EventsProviderCest
{
    public function checkFormProviders(\FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnRoute('/events/settings/providers');
        $I->see('Select providers');
        $I->submitForm('form#select-providers-form', [
            'FormProviders[providers]' => ''
        ]);
        $I->see('Your choice saved.');
    }
}