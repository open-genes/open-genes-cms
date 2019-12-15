<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model cms\models\ProteinActivity */

$this->title = 'Create Protein Activity';
$this->params['breadcrumbs'][] = ['label' => 'Protein Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="protein-activity-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
