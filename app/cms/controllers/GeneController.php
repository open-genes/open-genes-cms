<?php

namespace cms\controllers;

use cms\models\Age;
use cms\models\AgeRelatedChange;
use cms\models\CommentCause;
use cms\models\Gene;
use cms\models\FunctionalCluster;
use cms\models\GeneToProteinActivity;
use cms\models\LifespanExperiment;
use cms\models\ProteinClass;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
                        'actions' => ['index', 'create', 'update', 'update-experiments', 'update-functions', 'update-age-related-changes', 'delete', 'load-widget-form'],
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
            'searchModel' => new Gene(Yii::$app->request->get('Gene')),
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
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

        if(!empty(Yii::$app->request->post())) {
            if ($model->load(Yii::$app->request->post())) {
                if($model->save()) {
                    return $this->redirect(['update', 'id' => $model->id]);
                }
            }
        }
        $allFunctionalClusters = FunctionalCluster::findAllAsArray();
        $allCommentCauses = CommentCause::findAllAsArray();
        $allAges = Age::findAllAsArray();
        $allProteinClasses = ProteinClass::findAllAsArray();
        return $this->render('update', [
            'model' => $model,
            'allFunctionalClusters' => $allFunctionalClusters,
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

        if(Yii::$app->request->isPost) {
            if(is_array(Yii::$app->request->post('LifespanExperiment'))) {
                LifespanExperiment::saveMultipleForGene(Yii::$app->request->post('LifespanExperiment'), $id);
            }
            if(is_array(Yii::$app->request->post('AgeRelatedChange'))) {
                AgeRelatedChange::saveMultipleForGene(Yii::$app->request->post('AgeRelatedChange'), $id);
            }
            return $this->redirect(['update-experiments', 'id' => $model->id]);
        }

        return $this->render('updateExperiments', [
            'model' => $model,
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

        if(is_array(Yii::$app->request->post('GeneToProteinActivity'))) {
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

        return $this->redirect(['index']);
    }

    public function actionLoadWidgetForm($id, string $modelName, string $widgetName)
    {
        $modelName = "cms\models\\$modelName";
        $widgetName = "cms\widgets\\$widgetName";
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
