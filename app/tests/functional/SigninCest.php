<?php
use Codeception\Module\FactoryHelper;
class SigninCest
{
public function _before(FunctionalTester $I)
{
	$I->amOnRoute('cms/login');
	$I->haveUser('vasya','pupkin','vasya.pupkin@test.com','editor');
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

public function loginNonAdmin(\FunctionalTester $I)
{
	$I->submitForm('#login-form', [
		'LoginForm[username]' => 'vasya',
		'LoginForm[password]' => 'pupkin',
	]);
	$I->amOnPage('/gene');
	$I->see('Выйти (vasya)');
}

}; // class SigninCest
