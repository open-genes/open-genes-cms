<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProteinActivity */

$this->title = Yii::t('common', 'Edit protein activity') . ' ' . $model->id;
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
