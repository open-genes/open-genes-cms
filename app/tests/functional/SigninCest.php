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

public function loginWithWrongCredentials(\FunctionalTester $I)
{
	$I->submitForm('#login-form', [
		'LoginForm[username]' => 'wrong',
		'LoginForm[password]' => 'wrong',
	]);
	$I->see('Неверный логин или пароль');
}

public function loginSuccessfully(\FunctionalTester $I)
{
	$I->submitForm('#login-form', [
		'LoginForm[username]' => 'admin',
		'LoginForm[password]' => '123',
	]);
	$I->amOnPage('/gene');
	$I->see('Выйти (admin)');
}

}; // class SigninCest
