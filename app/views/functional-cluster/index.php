<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('common', 'Functional cluster');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="functional-cluster-index">

    <h2><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::a(Yii::t('common', 'Add'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name_en',
            'name_ru',
            [
                'label' => '🔗 genes',
                'value' => function($model, $index, $dataColumn) { /** @var $model \app\models\FunctionalCluster */
                    $geneIds = $model->getLinkedGenesIds();
                    $geneIdsString = implode(',', $geneIds);
                    $count = count($geneIds);
                    return $count ? "<a href='/gene?Gene[id]={$geneIdsString}' target='_blank'>{$count} 🔗</a>" : '-';
                },
                'headerOptions' => ['style' => 'width:90px'],
                'format' => 'raw'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'visibleButtons' => [
                    'update' => \Yii::$app->user->can('editor'),
                    'delete' => function ($model, $key, $index) { /** @var $model \app\models\FunctionalCluster */
                        return (\Yii::$app->user->can('editor') && !count($model->getLinkedGenesIds()))
                            || \Yii::$app->user->can('admin');
                    }
                ]
            ],
        ],
    ]); ?>


</div>
