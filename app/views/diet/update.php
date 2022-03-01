<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Genotype */

$this->title = 'Редактировать диету: ' . $model->id;
$this->title = 'Диета' . ' "' . $model->name_ru . '" - ' . Yii::t('app', 'update');

$this->params['breadcrumbs'][] = ['label' => 'Diet', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="genotype-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
