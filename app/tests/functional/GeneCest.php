<?php
use Codeception\Module\FactoryHelper;
class GeneCest
{

public function _before(FunctionalTester $I)
{
	$I->amOnRoute('cms/login');
	$I->submitForm('#login-form', [
		'LoginForm[username]' => 'admin',
		'LoginForm[password]' => '123',
	]);
}

public function openGenePage(\FunctionalTester $I)
{
	$I->amOnPage('/gene');
	$I->see('Showing 1-20 of');
}

public function openGeneUpdatePage(\FunctionalTester $I)
{
	$I->amOnPage('/gene/update?id=1');
	$I->see('Редактировать ген GHR');
}

public function updateGene(\FunctionalTester $I)
{
	$I->amOnRoute('/gene/update?id=1');
	$I->seeInDatabase('gene',['name'=>'growth hormone receptor']);
	$I->submitForm('.gene-form form', [
		'Gene[name]'=>'growth hormone receptor modified',
	]);
	$I->seeRecord('app\models\Gene',['id'=>1,'name'=>'growth hormone receptor modified']);
}

}; // class GeneCest

