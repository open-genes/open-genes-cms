<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('common', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('common', 'Add'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'username',
            'email',
            [
                'attribute' => 'status',
                'label' => Yii::t('common', 'Status'),
                'value' => function($model, $index, $dataColumn) { /** @var $model \app\models\User */
                    return $model->getStatusName();
                },
            ],
            [
                'label' => Yii::t('common', 'Role'),
                'value' => function($model, $index, $dataColumn) { /** @var $model \app\models\User */
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
