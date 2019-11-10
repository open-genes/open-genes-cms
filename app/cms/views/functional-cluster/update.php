<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model cms\models\FunctionalCluster */

$this->title = 'Update Functional Cluster: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Functional Clusters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="functional-cluster-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
