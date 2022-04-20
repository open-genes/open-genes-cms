<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ethnicity */

$this->title = 'Update Ethnicity: ' . $model->id;
$this->title = 'Ethnicity' . ' "' . $model->name_en . '" - ' . Yii::t('app', 'update');

$this->params['breadcrumbs'][] = ['label' => 'Ethnicities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ethnicity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
