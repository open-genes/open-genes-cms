<?php

use app\widgets\AgeRelatedChangeWidget;
use app\widgets\LifespanExperimentWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Gene */
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
<div class="gene-update container-fluid">
    <?php $form = ActiveForm::begin([
        'id' => 'experiments-form',
        'enableClientValidation' => true,
//        'enableAjaxValidation' => true

    ]); ?>
    <a href="<?= \yii\helpers\Url::toRoute(['update', 'id' => $model->id]) ?>" target="_blank" class="gene-link">Редактировать
        ген <?= $model->symbol ?> <span class="glyphicon glyphicon-pencil"></span></a>
    <h2><?= Html::encode($this->title) ?></h2>

    <div class="form-group">
        <h4>Влияние модуляции активности гена на продолжительность жизни</h4>
        <div class="js-lifespan-experiments">
            <?php foreach ($model->lifespanExperiments as $lifespanExperiment): ?>
                <?= LifespanExperimentWidget::widget(['model' => $lifespanExperiment]) ?>
            <?php endforeach; ?>
        </div>
        <?= Html::button('Добавить', ['class' => 'btn btn-add add-protein-activity js-add-lifespan-experiment']) ?>
    </div>

    <div class="form-group">
        <h4>Возрастные изменения экспрессии гена или активности белка</h4>
        <div class="js-age-related-changes">
            <?php foreach ($model->ageRelatedChanges as $ageRelatedChange): ?>
                <?= AgeRelatedChangeWidget::widget(['model' => $ageRelatedChange]) ?>
            <?php endforeach; ?>
        </div>
        <?= Html::button('Добавить', ['class' => 'btn btn-add add-protein-activity blue js-add-age-related-change']) ?>
    </div>

    <div class="form-group">
        <h4>Влияние модуляции активности гена на возрастной процесс</h4>
        <div class="js-intervention-to-vital-processes">
            <?php foreach ($model->geneInterventionToVitalProcesses as $geneInterventionToVitalProcess): ?>
                <?= \app\widgets\GeneInterventionToVitalProcessWidget::widget(['model' => $geneInterventionToVitalProcess]) ?>
            <?php endforeach; ?>
        </div>
        <?= Html::button('Добавить', ['class' => 'btn btn-add add-protein-activity green js-add-intervention-to-vital-process']) ?>
    </div>

    <div class="form-group">
        <h4>Участие продукта гена в регуляции генов, связанных со старением</h4>
        <div class="js-protein-to-genes">
            <?php foreach ($model->proteinToGenes as $proteinToGene): ?>
                <?= \app\widgets\ProteinToGeneWidget::widget(['model' => $proteinToGene]) ?>
            <?php endforeach; ?>
        </div>
        <?= Html::button('Добавить', ['class' => 'btn btn-add add-protein-activity yellow js-add-protein-to-gene']) ?>
    </div>

    <div class="form-group">
        <h4>Ассоциация гена с ускоренным старением у человека</h4>
        <div class="js-gene-to-progerias">
            <?php foreach ($model->geneToProgerias as $geneToProgeria): ?>
                <?= \app\widgets\GeneToProgeriaWidget::widget(['model' => $geneToProgeria]) ?>
            <?php endforeach; ?>
        </div>
        <?= Html::button('Добавить', ['class' => 'btn btn-add add-protein-activity orange js-add-gene-to-progeria']) ?>
    </div>

    <div class="form-group">
        <h4>Геномные, транскриптомные и протеомные ассоциации с продолжительностью жизни/возрастным фенотипом</h4>
        <div class="js-gene-to-longevity-effects">
            <?php foreach ($model->geneToLongevityEffects as $geneToLongevityEffect): ?>
                <?= \app\widgets\GeneToLongevityEffectWidget::widget(['model' => $geneToLongevityEffect]) ?>
            <?php endforeach; ?>
        </div>
        <?= Html::button('Добавить', ['class' => 'btn btn-add add-protein-activity red js-add-gene-to-longevity-effect']) ?>
    </div>

    <div class="form-group">
        <h4>Другие подтверждения ассоциации гена со старением</h4>
        <div class="js-gene-to-additional-evidence">
            <?php foreach ($model->geneToAdditionalEvidences as $geneToAdditionalEvidence): ?>
                <?= \app\widgets\AdditionalEvidencesWidget::widget(['model' => $geneToAdditionalEvidence]) ?>
            <?php endforeach; ?>
        </div>
        <?= Html::button('Добавить', ['class' => 'btn btn-add add-additional-evidence add-protein-activity gray js-add-additional-evidence']) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

