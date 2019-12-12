<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model cms\models\FunctionalCluster */

$this->title = 'Добавить функциональный кластер';
$this->params['breadcrumbs'][] = ['label' => 'Functional Clusters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="functional-cluster-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
