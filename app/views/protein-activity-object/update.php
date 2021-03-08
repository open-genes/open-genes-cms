<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProteinActivityObject */

$this->title = 'Редактировать объект активности белка ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Protein Activity Objects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="protein-activity-object-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
