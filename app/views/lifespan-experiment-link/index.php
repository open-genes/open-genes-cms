<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Lifespan Experiment Links');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lifespan-experiment-link-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'lifespan_experiment_from_id',
            'lifespan_experiment_to_id',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'visibleButtons' => [
                    'update' => \Yii::$app->user->can('contributor'),
                    'delete' => function ($model, $key, $index) {
                        return (\Yii::$app->user->can('editor') && !count($model->getLinkedGenesIds()))
                        || \Yii::$app->user->can('admin');
                        }
                ],
                'headerOptions' => ['style' => 'width:55px'],
            ],
        ],
    ]); ?>


</div>
