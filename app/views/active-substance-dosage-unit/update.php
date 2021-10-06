<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ActiveSubstanceDosageUnit */

$this->title = Yii::t('common', 'Edit active substance delivery way') . ' "' . $model->name_en . '"';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Active Substance Dosage Units'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="active-substance-dosage-unit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
