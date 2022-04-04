<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ExpressionEvaluation */

$this->title = 'Обновить Оценка экспрессии по: ' . ' "' . $model->name_en . '" - ' . Yii::t('app', 'update');

$this->params['breadcrumbs'][] = ['label' => 'Оценка экспрессии по ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="expression-evaluation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
