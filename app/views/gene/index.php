<?php

use app\models\Gene;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel Gene */

$this->title = Yii::t('common', 'Gene');
$this->params['breadcrumbs'][] = $this->title;

$experimentsNames = [
    'lifespan_experiment' => '<span style="background-color: #cbcbef"><?=Yii::t("common", "Lifespan experiment")?></span>',
    'age_related_change' => '<span style="background-color: #c8e5fd"><?=Yii::t("common", "Age related change")?></span>',
    'gene_intervention_to_vital_process' => '<span style="background-color: #c1e2aa"><?=Yii::t("common", "Gene intervention to vital process")?></span>',
    'protein_to_gene' => '<span style="background-color: #fbea95"><?=Yii::t("common", "Protein to gene")?></span>',
    'gene_to_progeria' => '<span style="background-color: #ffd8a9"><?=Yii::t("common", "Gene to progeria")?></span>',
    'gene_to_longevity_effect' => '<span style="background-color: #f5c3c2"><?=Yii::t("common", "Gene to longevity effect")?></span>',
    'gene_to_additional_evidence' => '<span style="background-color: #cacaca"><?=Yii::t("common", "Other")?></span>',
]
?>
<div class="gene-index container-fluid">
    <div class="row">
        <h2 class="col-xs-12"><?= Html::encode($this->title) ?></h2>
        <p class="col-xs-12">
            <?php if(Yii::$app->user->can('editor')): ?>
                <?= Html::a(Yii::t('common', 'Add gene'), ['create'], ['class' => 'btn btn-success']) ?>
                <?=Yii::$app->session->getFlash('add_genes') ?>
            <?endif; ?>
        </p>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ' - '],
        'columns' => [
            'id',
            'ncbi_id',
            'symbol',
            'name',
            [
                'attribute' => 'phylum',
                'label' => Yii::t('common', 'Phylum'),
                'value' => function($model, $index, $dataColumn) { /** @var $model Gene */
                    return $model->phylum ? "{$model->phylum->name_phylo} ({$model->phylum->name_mya})" : '-';
                },
            ],
            [
                'attribute' => 'familyPhylum',
                'label' => Yii::t('common', 'Family Phylum'),
                'value' => function($model, $index, $dataColumn) { /** @var $model Gene */
                    return $model->familyPhylum ? "{$model->familyPhylum->name_phylo} ({$model->familyPhylum->name_mya})" : '-';
                },
            ],
            'aliases',
            [
                'attribute' => 'source',
                'filter'=> Html::dropDownList('Gene[source]', $searchModel->source, ['abdb' => 'abdb', 'horvath' => 'horvath'],['prompt'=>' ','class' => 'form-control']),
            ],
            [
                'label' => Yii::t('common', 'Research'),
                'value' => function($model, $index, $dataColumn) use ($experimentsNames) { /** @var $model Gene */
                    $url = \yii\helpers\Url::toRoute(['update-experiments', 'id' => $model->id]);
                    $experimentCounts = $model->getAllExperimentsCounts();
                    $text = '';
                    foreach ($experimentCounts as $name => $count) {
                        $text .= $experimentsNames[$name] . ' - ' . $count . '<br>';
                    }
                    $text = $text ?: Yii::t('common', 'Add');
                    return "<a href='{$url}' target='_blank' style='font-size: 11px; color: black'>{$text}</a>";
                },
                'format' => 'raw',
                'filter'=> Html::dropDownList('Gene[filledExperiments]', $searchModel->filledExperiments, ['+' => '+', '-' => '-'],['prompt'=>' ','class' => 'form-control']),
                'headerOptions' => ['style' => 'min-width:200px'],
            ],
            //'ncbi_id',
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
            //'commentCause',
            //'commentAging',
            //'commentEvolutionEN',
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

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'visibleButtons' => [
                    'update' => \Yii::$app->user->can('contributor'),
                    'delete' => \Yii::$app->user->can('admin'),
                ],
                'headerOptions' => ['style' => 'min-width:50px'],
            ],
        ],
    ]); ?>


</div>
