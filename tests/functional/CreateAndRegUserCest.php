<?php

/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 16.12.2016
 * Time: 20:09
 */
class CreateAndRegUserCest
{

    public function createUserProcess(\FunctionalTester $I)
    {
        $I->amLoggedInAs(1);
        $I->amOnRoute('/user/admin/create');
        $I->see('Create a user account');
        $I->submitForm('div.panel-body > form', [
            'User[email]' => rand(100000,999999).'@sadasdasdasd.ru',
            'User[username]' => 'test_'.rand(100,999),
            'User[password]' => rand(10000000,999999999)
        ]);
        $I->see('User has been created');
        $I->canSeeEmailIsSent();
        $I->submitForm('form#logoutForm',[]);
        $I->cantSee('Sign out');
        $modelToken = \app\modules\users\models\Token::find()->orderBy('user_id DESC')->one();
        $I->amOnRoute('/user/registration/confirm',[
            'id'=>$modelToken->user_id,
            'code'=>$modelToken->code,
            'type'=>'invitation'
            ]
        );
        $I->see('Enter your password');
        $I->submitForm('form', [
            'enter-password-form[password]' => '21312312'
        ]);
        $I->see('Thank you, registration is now complete.');
        $I->see('Sign out');
    }

    public function regUserProcess(\FunctionalTester $I)
    {
        $I->amOnRoute('user/registration/register');
        $I->submitForm('form', [
            'register-form[email]' => rand(100000,999999).'-user@g23423423mail.com',
            'register-form[username]' => 'user_'.rand(100000,999999),
            'register-form[password]' => '32432432'
        ]);
        $I->see('Your account has been created and a message with further instructions has been sent to your email');
        $I->canSeeEmailIsSent();
        $modelToken = \app\modules\users\models\Token::find()->orderBy('user_id DESC')->one();
        $I->amOnRoute('/user/registration/confirm',[
                'id'=>$modelToken->user_id,
                'code'=>$modelToken->code
            ]
        );
        $I->see('Thank you, registration is now complete.');
        $I->see('Sign out');
    }

}