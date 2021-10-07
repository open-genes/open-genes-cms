<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ExperimentMainEffect */

$this->title = Yii::t('app', 'Update Experiment Main Effect: {name}', [
    'name' => $model->id,
]);
$this->title = Yii::t('app', 'Experiment Main Effect') . ' "' . $model->name_en . '" - ' . Yii::t('app', 'update');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Experiment Main Effects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="experiment-main-effect-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
