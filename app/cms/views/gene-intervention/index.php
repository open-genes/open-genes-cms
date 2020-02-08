<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Методы вмешательства';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gene-intervention-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить метод вмешательства', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'name_ru',
            'name_en',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
        ],
    ]); ?>


</div>
