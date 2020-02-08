<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model cms\models\GeneIntervention */

$this->title = 'Добавить метод вмешательства';
$this->params['breadcrumbs'][] = ['label' => 'Gene Interventions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gene-intervention-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
