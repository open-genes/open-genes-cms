<?php

use app\widgets\LifespanExperimentWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Gene */
/* @var $allFunctionalClusters [] */
/* @var $allCommentCauses [] */
/* @var $allProteinClasses [] */
/* @var $allAges [] */

$this->registerJsFile('/assets/js/experiments.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('/assets/css/gene.css');

$this->title = 'Функции гена ' . $model->symbol;
$this->params['breadcrumbs'][] = ['label' => 'Genes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->symbol, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gene-update">
    <?php $form = ActiveForm::begin(); ?>
    <a href="<?=\yii\helpers\Url::toRoute(['update', 'id' => $model->id])?>" target="_blank" class="gene-link">Редактировать ген <?=$model->symbol ?> <span class="glyphicon glyphicon-pencil"></span></a>
    <h2><?= Html::encode($this->title) ?></h2>
    <?= Html::button('Добавить', ['class' => 'btn add-protein-activity js-add-protein-activity']) ?>
    <div class="js-protein-activities">
        <?php foreach ($model->geneToProteinActivities as $geneToProteinActivity): ?>
            <?= \app\widgets\GeneProteinActivity::widget(['model' => $geneToProteinActivity]) ?>
        <?php endforeach; ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
