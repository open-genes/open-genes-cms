<?php

use cms\widgets\AgeRelatedChangeWidget;
use cms\widgets\LifespanExperimentWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model cms\models\Gene */
/* @var $allFunctionalClusters [] */
/* @var $allCommentCauses [] */
/* @var $allProteinClasses [] */
/* @var $allAges [] */

$this->registerJsFile('/assets/js/gene.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('/assets/css/gene.css');

$this->title = 'Исследования гена ' . $model->symbol;
$this->params['breadcrumbs'][] = ['label' => 'Genes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->symbol, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gene-update">
    <?php $form = ActiveForm::begin(); ?>
    <a href="<?=\yii\helpers\Url::toRoute(['update', 'id' => $model->id])?>" target="_blank" class="gene-link">Редактировать ген <?=$model->symbol ?> <span class="glyphicon glyphicon-pencil"></span></a>
    <h2><?= Html::encode($this->title) ?></h2>
    <h5>Эксперименты с увеличением продолжительности жизни</h5> <?= Html::button('Добавить', ['class' => 'btn add-protein-activity js-add-lifespan-experiment']) ?>
    <div class="js-lifespan-experiments">
        <?php foreach ($model->lifespanExperiments as $lifespanExperiment): ?>
            <?= LifespanExperimentWidget::widget(['model' => $lifespanExperiment]) ?>
        <?php endforeach; ?>
    </div>
    <h5>Возрастные изменения экспрессии гена/активности белка</h5> <?= Html::button('Добавить', ['class' => 'btn add-protein-activity js-add-age-related-change']) ?>
    <div class="js-age-related-changes">
        <?php foreach ($model->ageRelatedChanges as $ageRelatedChange): ?>
            <?= AgeRelatedChangeWidget::widget(['model' => $ageRelatedChange]) ?>
        <?php endforeach; ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
