<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model cms\models\Gene */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Genes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="gene-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'agePhylo',
            'ageMya',
            'symbol',
            'aliases',
            'name',
            'entrezGene',
            'uniprot',
            'why',
            'band',
            'locationStart',
            'locationEnd',
            'orientation',
            'accPromoter',
            'accOrf',
            'accCds',
            'references',
            'orthologs',
            'commentEvolution',
            'commentFunction',
            'commentCause',
            'commentAging',
            'commentEvolutionEN',
            'commentFunctionEN',
            'commentAgingEN',
            'commentsReferenceLinks',
            'rating',
            'functionalClusters',
            'dateAdded',
            'userEdited',
            'isHidden',
            'expression:ntext',
            'expressionEN:ntext',
            'expressionChange',
        ],
    ]) ?>

</div>
