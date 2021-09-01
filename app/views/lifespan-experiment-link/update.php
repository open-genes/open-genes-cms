<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LifespanExperimentLink */

$this->title = Yii::t('app', 'Update Lifespan Experiment Link: {name}', [
    'name' => $model->id,
]);
$this->title = Yii::t('app', 'Lifespan Experiment Link') . ' "' . $model->name_en . '" - ' . Yii::t('app', 'update');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lifespan Experiment Links'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="lifespan-experiment-link-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
