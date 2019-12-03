<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model cms\models\ProteinActivityObject */

$this->title = 'Update Protein Activity Object: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Protein Activity Objects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="protein-activity-object-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
