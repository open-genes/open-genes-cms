<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Gene */
/* @var $allFunctionalClusters [] */
/* @var $allDiseases [] */
/* @var $allCommentCauses [] */
/* @var $allProteinClasses [] */
/* @var $allAges [] */

$this->title = 'Редактировать ген ' . $model->symbol;
$this->params['breadcrumbs'][] = ['label' => 'Genes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->symbol, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gene-update">
    <?php if(Yii::$app->user->can('editor')): ?>
        <a href="<?=\yii\helpers\Url::toRoute(['update-functions', 'id' => $model->id])?>" target="_blank" class="gene-link">Функции гена <span class="glyphicon glyphicon-pencil"></span></a>
    <?php endif; ?>
    <a href="<?=\yii\helpers\Url::toRoute(['update-experiments', 'id' => $model->id])?>" target="_blank" class="gene-link">Исследования гена <span class="glyphicon glyphicon-pencil"></span></a>
    <h2><?= Html::encode($this->title) ?></h2>
    <?= $this->render('_form', [
        'model' => $model,
        'allFunctionalClusters' => $allFunctionalClusters,
        'allDiseases' => $allDiseases,
        'allCommentCauses' => $allCommentCauses,
        'allProteinClasses' => $allProteinClasses,
        'allAges' => $allAges,
    ]) ?>

</div>
