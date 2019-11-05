<?php
namespace common\console\controllers;

use common\models\User;
use yii\console\Controller;

class UserController extends Controller
{
    public function behaviors()
    {
        return parent::behaviors();
    }

    /**
     * Create new user with privileges. Usage: `user/create-user name password email@email.com admin`
     *
     * @param string $name
     * @param string $password
     * @param string $email
     * @param string $role
     * @throws \Exception
     */
    public function actionCreateUser($name = 'username', $password = 'password', $email = 'example@genes.com', $role = 'admin')
    {
        $user = new User();
        $user->username = $name;
        $user->email = $email;
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
        $user->save();

        $auth = \Yii::$app->authManager;
        $authorRole = $auth->getRole($role);
        $auth->assign($authorRole, $user->getId());
    }


}
