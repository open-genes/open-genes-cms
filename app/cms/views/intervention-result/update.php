<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model cms\models\InterventionResult */

$this->title = 'Редактировать результат вмешательства ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Intervention Results', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="intervention-result-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
