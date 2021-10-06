<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrganismLine */
/* @var $organismList array */

$this->title = Yii::t('common', 'Edit organism line') . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Organism Lines', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="organism-line-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'organismList' => $organismList,
    ]) ?>

</div>
