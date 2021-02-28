<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model cms\models\ProteinActivity */

$this->title = 'Редактировать вид активности протеина ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Protein Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="protein-activity-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
