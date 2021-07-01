<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ModelOrganism */

$this->title = 'Добавить объект (модельный организм)';
$this->params['breadcrumbs'][] = ['label' => 'Model Organisms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="model-organism-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
