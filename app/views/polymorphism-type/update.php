<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PolymorphismType */

$this->title = 'Update Polymorphism Type: ' . $model->id;
$this->title = 'Вид полиморфизма' . ' "' . $model->name_en . '" - ' . Yii::t('app', 'update');

$this->params['breadcrumbs'][] = ['label' => 'Polymorphism Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="polymorphism-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
