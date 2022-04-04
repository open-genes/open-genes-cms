<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StatisticalMethod */

$this->title = 'Update Statistical Method: ' . $model->id;
$this->title = 'Статистический анализ' . ' "' . $model->name_en . '" - ' . Yii::t('app', 'update');

$this->params['breadcrumbs'][] = ['label' => 'Statistical Methods', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="statistical-method-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
