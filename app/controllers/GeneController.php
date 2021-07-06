<?php

namespace app\controllers;

use app\models\AgeRelatedChange;
use app\models\Disease;
use app\models\exceptions\UpdateExperimentsErrorException;
use app\models\exceptions\UpdateExperimentsValidationException;
use app\models\GeneToAdditionalEvidence;
use app\models\GeneToLongevityEffect;
use app\models\GeneToProgeria;
use app\models\Phylum;
use app\models\CommentCause;
use app\models\Gene;
use app\models\FunctionalCluster;
use app\models\GeneInterventionToVitalProcess;
use app\models\GeneToProteinActivity;
use app\models\LifespanExperiment;
use app\models\ProteinClass;
use app\models\ProteinToGene;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\View;

/**
 * GeneController implements the CRUD actions for Gene model.
 */
class GeneController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'update', 'update-experiments', 'update-functions', 'update-age-related-changes', 'load-widget-form'],
                        'roles' => ['admin', 'editor', 'contributor'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'delete'],
                        'roles' => ['admin', 'editor'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Gene models.
     * @return mixed
     */
    public function actionIndex()
    {
        $arGene = new Gene(Yii::$app->request->get('Gene'));
        $dataProvider = $arGene->search();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $arGene,
        ]);
    }

    /**
     * Creates a new Gene model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Gene();

        if ($model->load(Yii::$app->request->post()) && $model->createByNCBIIds()) {
            Yii::$app->session->setFlash('add_genes', 'Гены успешно добавлены, Вы можете найти их по id в таблице');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Gene model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (!empty(Yii::$app->request->post())) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    return $this->redirect(['update', 'id' => $model->id]);
                }
            }
        }
        $allFunctionalClusters = FunctionalCluster::findAllAsArray();
        $allCommentCauses = CommentCause::findAllAsArray();
        $allDiseases = Disease::findAllAsArray();
        $allAges = Phylum::findAllAsArray();
        $allProteinClasses = ProteinClass::findAllAsArray();
        return $this->render('update', [
            'model' => $model,
            'allFunctionalClusters' => $allFunctionalClusters,
            'allDiseases' => $allDiseases,
            'allCommentCauses' => $allCommentCauses,
            'allProteinClasses' => $allProteinClasses,
            'allAges' => $allAges,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionUpdateExperiments($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $savedARs = [];
            $result = [];
            try {
                if (is_array(Yii::$app->request->post('LifespanExperiment'))) {
                    $savedARs['LifespanExperiment'] = LifespanExperiment::saveMultipleForGene(Yii::$app->request->post('LifespanExperiment'), $id);
                }
                if (is_array(Yii::$app->request->post('AgeRelatedChange'))) {
                    $savedARs['AgeRelatedChange'] = AgeRelatedChange::saveMultipleForGene(Yii::$app->request->post('AgeRelatedChange'), $id);
                }
                if (is_array(Yii::$app->request->post('GeneInterventionToVitalProcess'))) {
                    $savedARs['GeneInterventionToVitalProcess'] = GeneInterventionToVitalProcess::saveMultipleForGene(Yii::$app->request->post('GeneInterventionToVitalProcess'), $id);
                }
                if (is_array(Yii::$app->request->post('ProteinToGene'))) {
                    $savedARs['ProteinToGene'] = ProteinToGene::saveMultipleForGene(Yii::$app->request->post('ProteinToGene'), $id);
                }
                if (is_array(Yii::$app->request->post('GeneToProgeria'))) {
                    $savedARs['GeneToProgeria'] = GeneToProgeria::saveMultipleForGene(Yii::$app->request->post('GeneToProgeria'), $id);
                }
                if (is_array(Yii::$app->request->post('GeneToLongevityEffect'))) {
                    $savedARs['GeneToLongevityEffect'] = GeneToLongevityEffect::saveMultipleForGene(Yii::$app->request->post('GeneToLongevityEffect'), $id);
                }
                if (is_array(Yii::$app->request->post('GeneToAdditionalEvidence'))) {
                    $savedARs['GeneToAdditionalEvidence'] = GeneToAdditionalEvidence::saveMultipleForGene(Yii::$app->request->post('GeneToAdditionalEvidence'), $id);
                }
            } catch (UpdateExperimentsValidationException $e) {
                $result['error'] = $e->getInfoArray();
            } catch (UpdateExperimentsErrorException $e) {
                $result['fatal_error'] = $e->getMessage();
            }
            if ($savedARs) {
                $result['success'] = $savedARs;
            }
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        }

        return $this->render('updateExperiments', [
            'model' => $model,
            'userId' => Yii::$app->user->getId(),
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionUpdateFunctions($id)
    {
        $model = $this->findModel($id);

        if (is_array(Yii::$app->request->post('GeneToProteinActivity'))) {
            GeneToProteinActivity::saveMultipleForGene(Yii::$app->request->post('GeneToProteinActivity'), $id);
            return $this->redirect(['update-functions', 'id' => $model->id]);
        }

        return $this->render('updateFunctions', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Gene model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $redirectUrl = strpos(Yii::$app->request->referrer, Url::to(['index'])) !== false
            ? Yii::$app->request->referrer : Url::to(['index']);
        return $this->redirect($redirectUrl);
    }

    public function actionLoadWidgetForm($id, string $modelName, string $widgetName)
    {
        $modelName = "app\models\\$modelName";
        $widgetName = "app\widgets\\$widgetName";
        if ($id) {
            $model = $modelName::findOne($id);
        }
        if (!isset($model)) {
            $model = new $modelName();
            $model->id = $id;
        }
        return $this->renderAjax('_geneLinkWidgetForm', ['model' => $model, 'widgetName' => $widgetName]);
    }

    /**
     * Finds the Gene model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Gene the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Gene::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
