<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrganismLine */

$this->title = 'Добавить линию организмов';
$this->params['breadcrumbs'][] = ['label' => 'Organism Lines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organism-line-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
