<?php
namespace Codeception\Module;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class FactoryHelper extends \Codeception\Module
{
	protected $factory;

	public function _initialize()
	{
		$this->fm=new \saada\FactoryMuffin\FactoryMuffin();
		$this->fm->define('app\models\User');
	}
	public function haveUser($username,$password,$email,$role)
	{
		\Yii::$app->user->identity=unserialize('O:15:"app\models\User":1:{s:8:"username";s:5:"dummy";}');
		$security = \Yii::$app->getSecurity();
		$u=$this->fm->create('app\models\User',[
			'email'=>$email,
			'username' => $username,
			'auth_key' => $security->generateRandomString(),
			'password_hash' => $security->generatePasswordHash('pupkin'),
			'status'=>10,
			'password_reset_token' => $security->generateRandomString() . '_' . time(),
		]);
		unset(\Yii::$app->user->identity);
		$auth = \Yii::$app->authManager;
		$r=$auth->getRole($role);
		$auth->assign($r, $u->getId());
	}


}
