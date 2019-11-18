<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model cms\models\GeneToFunctionRelationType */

$this->title = 'Create Gene To Function Relation Type';
$this->params['breadcrumbs'][] = ['label' => 'Gene To Function Relation Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gene-to-function-relation-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
