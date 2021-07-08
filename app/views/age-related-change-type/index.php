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
            [
                'label' => '🔗 genes',
                'value' => function($model, $index, $dataColumn) { /** @var $model \app\models\AgeRelatedChangeType */
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
