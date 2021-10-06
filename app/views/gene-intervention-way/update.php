<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GeneInterventionWay */

$this->title = Yii::t('common', 'Edit gene intervention way') . ' "' . $model->name_en . '"';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gene Intervention Ways'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="gene-intervention-way-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
