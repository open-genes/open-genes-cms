<?php
namespace cms\controllers;

use common\models\LoginForm;
use common\models\PasswordResetRequestForm;
use common\models\ResetPasswordForm;
use common\models\SignupForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class CmsController extends Controller
{
    public function behaviors()
    {
        return [
//            'access' => [
//                'class' => AccessControl::class,
//                'rules' => [
//                    [
//                        'actions' => ['index'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                    [
//                        'actions' => ['gene'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $this->redirect('/gene'); // todo
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionRegister()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Спасибо за регистрацию! Скоро мы активируем Ваш аккаунт.');
            $this->sendRegisterNotifyEmail($model->email);
            $this->sendRegisterUserEmail($model->email);
            $model = new SignupForm();
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'На Вашу почту отправлено письмо со ссылкой для смены пароля');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Произошла ошибка. Пожалуйста, обратитесь к администратору');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Новый пароль сохранен');
            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function goHome()
    {
        return Yii::$app->getResponse()->redirect('/');
    }

    public function actionError()
    {
        if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
            $exception = new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
        Yii::$app->getResponse()->setStatusCodeByException($exception);

        return $this->render('error', ['exception' => $exception]);
    }


    protected function sendRegisterNotifyEmail($userEmail)
    {
        $link = Yii::$app->urlManager->createAbsoluteUrl(['user']);
        return Yii::$app
            ->mailer
            ->compose()
            ->setTextBody('Новая регистрация на Open Genes, ' . $userEmail . ', активировать: ' . $link)
            ->setFrom([Yii::$app->params['adminEmail'] => 'Open Genes'])
            ->setTo(Yii::$app->params['notifyEmails'])
            ->setSubject('Новая регистрация на Open Genes')
            ->send();
    }

    protected function sendRegisterUserEmail($userEmail)
    {
        return Yii::$app
            ->mailer
            ->compose()
            ->setTextBody('Спасибо за регистрацию в проекте Open Genes! ' . PHP_EOL . 'Мы активируем Ваш аккаунт и сообщим Вам.')
            ->setFrom([Yii::$app->params['adminEmail'] => 'Open Genes'])
            ->setTo($userEmail)
            ->setSubject('Регистрация в Open Genes')
            ->send();
    }


}
