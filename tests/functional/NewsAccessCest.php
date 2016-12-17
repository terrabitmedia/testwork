<?php
class NewsAccessCest
{

    public function isGuest(\FunctionalTester $I)
    {
        $I->amOnPage('/');
        $I->dontSee('Create News','a');
        $I->dontSee('Read more','a');
        $I->dontSee('Update','a');
        $I->dontSee('Delete','a');
    }

    public function isAdmin(\FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnPage('/');
        $I->see('Create News','a');
        $I->see('Read more','a');
        $I->see('Update','a');
        $I->see('Delete','a');
    }

    public function isManager(\FunctionalTester $I)
    {
        $I->amLoggedInAs(2);
        $I->amOnPage('/');
        $I->see('Create News','a');
        $I->see('Read more','a');
        $I->see('Update','a');
        $I->see('Delete','a');
    }

    public function isUser(\FunctionalTester $I)
    {
        $I->amLoggedInAs(3);
        $I->amOnPage('/');
        $I->dontSee('Create News','a');
        $I->see('Read more','a');
        $I->dontSee('Update','a');
        $I->dontSee('Delete','a');
    }

}