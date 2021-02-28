<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model cms\models\OrganismLine */

$this->title = 'Редактировать линию организмов ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Organism Lines', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="organism-line-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
