<?php

use cms\models\Gene;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel Gene */

$this->title = 'Гены';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gene-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить ген', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ' - '],
        'columns' => [
            'id',
            'symbol',
            'name',
            [
                'attribute' => 'age',
                'label' => 'Возраст',
                'value' => function($model, $index, $dataColumn) { /** @var $model Gene */
                    return $model->age ? "{$model->age->name_phylo} ({$model->age->name_mya})" : '-';
                },
            ],
            'aliases',
            //'entrezGene',
            //'uniprot',
            //'why',
            //'band',
            //'locationStart',
            //'locationEnd',
            //'orientation',
            //'accPromoter',
            //'accOrf',
            //'accCds',
            //'references',
            //'orthologs',
            //'commentEvolution',
            //'commentFunction',
            //'commentCause',
            //'commentAging',
            //'commentEvolutionEN',
            //'commentFunctionEN',
            //'commentAgingEN',
            //'commentsReferenceLinks',
            //'rating',
            //'functionalClusters',
            //'dateAdded',
            //'userEdited',
            //'isHidden',
            //'expression:ntext',
            //'expressionEN:ntext',
            //'expressionChange',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update}'],
        ],
    ]); ?>


</div>
