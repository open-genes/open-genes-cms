<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GeneIntervention */

$this->title = Yii::t('common', 'Edit gene intervention') . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gene Interventions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gene-intervention-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
