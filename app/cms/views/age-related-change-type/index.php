<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Вид возрастных изменений гена/белка';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="age-related-change-type-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить вид возрастных изменений гена/белка', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'name_ru',
            'name_en',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update}'],
        ],
    ]); ?>


</div>
