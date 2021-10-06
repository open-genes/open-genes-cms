<?php
namespace app\models\common;

use Yii;
use yii\base\Model;
use app\models\common\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('common', 'Login'),
            'password' => Yii::t('common', 'Password'),
            'email' => 'Email',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'match', 'pattern' => '/^[a-z][\w-]*$/i', 'message' => Yii::t('common', 'Login can contain only latin letters and dashes')],
            ['username', 'unique', 'targetClass' => '\app\models\common\User', 'message' => Yii::t('common', 'This name is already taken')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\common\User', 'message' => Yii::t('common', 'This email is already taken')],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->status = User::STATUS_INACTIVE;
        return $user->save();

    }

}