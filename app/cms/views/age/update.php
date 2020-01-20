<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model cms\models\Phylum */

$this->title = 'Редактировать филум ' . $model->name_phylo;
$this->params['breadcrumbs'][] = ['label' => 'Ages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="age-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
