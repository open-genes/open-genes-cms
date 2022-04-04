<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MeasurementType */

$this->title = 'Обновить метод измерения: ' . $model->id;
$this->title = 'Метод измерения ' . ' "' . $model->name_en . '" - ' . Yii::t('app', 'update');

$this->params['breadcrumbs'][] = ['label' => 'Метод измерения ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="measurement-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
