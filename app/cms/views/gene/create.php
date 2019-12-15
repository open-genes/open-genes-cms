<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model cms\models\Gene */

$this->title = 'Create Gene';
$this->params['breadcrumbs'][] = ['label' => 'Genes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gene-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
