<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Gene */

$this->title = 'Create Gene';
$this->params['breadcrumbs'][] = ['label' => 'Genes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gene-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
