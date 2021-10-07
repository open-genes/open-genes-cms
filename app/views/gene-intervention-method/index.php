<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Gene Intervention Methods');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gene-intervention-method-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'name_ru',
            'name_en',
            'geneInterventionWay.name_en',
            [
                'attribute' => 'gene_intervention_way_id',
                'label' => 'Способ воздействия',
                'value' => function($model, $index, $dataColumn) { /** @var $model \app\models\GeneInterventionMethod */
                    return $model->geneInterventionWay ? "{$model->geneInterventionWay->name_ru} ({$model->geneInterventionWay->name_en})" : '-';
                },
            ],
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
