<?php
namespace cms\models\common;

use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Model;
use cms\models\common\User;
use yii\helpers\Html;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => User::class,
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }
        $link = Yii::$app->urlManager->createAbsoluteUrl(['cms/reset-password', 'token' => $user->password_reset_token]);
        return Yii::$app
            ->mailer
            ->compose()
            ->setTextBody('Здравствуйте! Вы запросили сброс пароля на Open Genes. Чтобы продолжить, пройдите по ссылке: ' . $link)
            ->setFrom([Yii::$app->params['adminEmail'] => 'Open Genes'])
            ->setTo($this->email)
            ->setSubject('Восстановление пароля на Open Genes')
            ->send();
    }
}
