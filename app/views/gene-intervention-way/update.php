<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GeneInterventionWay */

$this->title = Yii::t('app', 'Update Gene Intervention Way: {name}', [
    'name' => $model->id,
]);
$this->title = Yii::t('app', 'Gene Intervention Way') . ' "' . $model->name_en . '" - ' . Yii::t('app', 'update');

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
