<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'username',
            [
                'attribute' => 'status',
                'label' => 'Статус',
                'value' => function($model, $index, $dataColumn) { /** @var $model \cms\models\User */
                    return $model->getStatusName();
                },
            ],
            [
                'label' => 'Роль',
                'value' => function($model, $index, $dataColumn) { /** @var $model \cms\models\User */
                    return implode(', ', $model->getRolesArray()) ;
                },
            ],
            //'created_at',
            //'updated_at',
            //'auth_key',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>


</div>
