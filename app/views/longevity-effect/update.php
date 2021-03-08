<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LongevityEffect */

$this->title = 'Редактировать эффект продолжительности жизни ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Longevity Effects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="longevity-effect-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
