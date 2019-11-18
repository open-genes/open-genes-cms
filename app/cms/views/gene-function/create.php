<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model cms\models\GeneFunction */

$this->title = 'Create Gene Function';
$this->params['breadcrumbs'][] = ['label' => 'Gene Functions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gene-function-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
