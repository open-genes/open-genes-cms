<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model cms\models\ModelOrganism */

$this->title = 'Редактировать модельный организм ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Model Organisms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="model-organism-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
