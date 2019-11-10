<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model cms\models\Age */

$this->title = 'Update Age: ' . $model->name_phylo;
$this->params['breadcrumbs'][] = ['label' => 'Ages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="age-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
