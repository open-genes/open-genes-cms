<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model cms\models\GeneFunction */

$this->title = 'Update Gene Function: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gene Functions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gene-function-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
