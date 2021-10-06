<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GeneRegulationType */

$this->title = Yii::t('common', 'Edit gene regulation type') . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gene Regulation Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gene-regulation-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
