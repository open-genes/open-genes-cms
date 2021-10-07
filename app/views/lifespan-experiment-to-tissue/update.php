<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LifespanExperimentToTissue */

$this->title = Yii::t('app', 'Update Lifespan Experiment To Tissue: {name}', [
    'name' => $model->id,
]);
$this->title = Yii::t('app', 'Lifespan Experiment To Tissue') . ' "' . $model->name_en . '" - ' . Yii::t('app', 'update');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lifespan Experiment To Tissues'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="lifespan-experiment-to-tissue-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
