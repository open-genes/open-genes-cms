<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model cms\models\GeneToFunctionRelationType */

$this->title = 'Update Gene To Function Relation Type: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gene To Function Relation Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gene-to-function-relation-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
