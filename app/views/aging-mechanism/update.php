<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AgingMechanism */

$this->title = Yii::t('app', 'Update Aging Mechanism: {name}', [
    'name' => $model->id,
]);
$this->title = Yii::t('app', 'Aging Mechanism') . ' "' . $model->name_en . '" - ' . Yii::t('app', 'update');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Aging Mechanisms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="aging-mechanism-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
