<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Disease */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('common', 'Disease');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disease-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('common', 'Add'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'omim_id',
            'name_ru',
            'name_en',
            'icd_code',
            'parent_icd_code',
            'icd_name_en',
            'icd_name_ru',
            'icd_code_visible',
//            'created_at',
            //'updated_at',
            [
                'label' => '🔗 genes',
                'value' => function($model, $index, $dataColumn) { /** @var $model \app\models\Disease */
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
                    'update' => \Yii::$app->user->can('contributor'),
                    'delete' => function ($model, $key, $index) {
                        return (\Yii::$app->user->can('editor') && !count($model->getLinkedGenesIds()))
                            || \Yii::$app->user->can('admin');
                    }
                ]
            ],
        ],
    ]); ?>


</div>
