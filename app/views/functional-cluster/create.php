<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FunctionalCluster */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Functional Clusters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="functional-cluster-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
