<?php
namespace app\console\controllers;

use app\models\common\User;
use yii\console\Controller;

class UserController extends Controller
{
    public function behaviors()
    {
        return parent::behaviors();
    }

    /**
     * Create new user with privileges. Usage: `user/create name password email@email.com admin`
     *
     * @param string $name
     * @param string $password
     * @param string $email
     * @param string $role
     * @throws \Exception
     */
    public function actionCreate($name = 'username', $password = 'password', $email = 'example@genes.com', $role = 'editor')
    {
        $user = new User();
        $user->username = $name;
        $user->email = $email;
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;
        $user->save();

        $auth = \Yii::$app->authManager;
        $authRole = $auth->getRole($role);
        $auth->assign($authRole, $user->getId());
    }

    /**
     * Assign role to user. Usage: `user/assign name role [revokeOtherRoles=false]`
     * @param string $name
     * @param string $role
     * @param bool $revokeOther
     * @throws \Exception
     */
    public function actionAssign($name = 'username', $role = 'editor', $revokeOther = false)
    {
        $user = User::find()->where(['username' => $name])->one();
        if($user) {
            $auth = \Yii::$app->authManager;
            $newRole = $auth->getRole($role);
            if($revokeOther) {
                $oldRoles = $auth->getRolesByUser($user->getId());
                foreach ($oldRoles as $oldRole) {
                    $auth->revoke($oldRole, $user->getId());
                }
            }
            $auth->assign($newRole, $user->getId());
        } else {
            echo "couldn't find user $name";
        }
    }


}
