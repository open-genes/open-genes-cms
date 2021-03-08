<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProteinActivityObject */

$this->title = 'Create Protein Activity Object';
$this->params['breadcrumbs'][] = ['label' => 'Protein Activity Objects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="protein-activity-object-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
