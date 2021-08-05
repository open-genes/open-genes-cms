<?php

class SigninCest
{

public function _before(FunctionalTester $I)
{
	$I->amOnRoute('cms/login');
}

public function openLoginPage(\FunctionalTester $I)
{
	$I->see('Войти', 'button');
}

}; // class SigninCest
