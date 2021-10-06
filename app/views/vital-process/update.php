<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VitalProcess */

$this->title = Yii::t('common', 'Edit vital process') . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vital Processes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vital-process-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
