<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Возрастозависимые процессы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="functional-cluster-index">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::a('Добавить возрастозависимый процесс', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name_en',
            'name_ru',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'visibleButtons' => [
                    'update' => \Yii::$app->user->can('editor'),
                    'delete' => function ($model, $key, $index) {
                        return \Yii::$app->user->can('editor') && ! $model->getAgeRelatedChanges()->select('gene.id')->distinct()->count()
                            || \Yii::$app->user->can('admin');
                    }
                ]
            ],
        ],
    ]); ?>


</div>
