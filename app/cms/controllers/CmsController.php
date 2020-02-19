<?php
namespace cms\controllers;

use common\models\LoginForm;
use common\models\SignupForm;
use Yii;
use yii\filters\VerbFilter;
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
            $message = 'Спасибо за регистрацию! Скоро мы активируем Ваш аккаунт.';
            $this->sendNotifyEmail($model->email);
        }

        return $this->render('signup', [
            'model' => $model,
            'message' => $message
        ]);
    }

    protected function sendNotifyEmail($userEmail)
    {
        return Yii::$app
            ->mailer
            ->compose()
            ->setTextBody('Новая регистрация на Open Genes - ' . $userEmail)
            ->setFrom([Yii::$app->params['adminEmail'] => 'Open Genes'])
            ->setTo(Yii::$app->params['checkEmail'])
            ->setSubject('Account registration at Open Genes')
            ->send();
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



}
