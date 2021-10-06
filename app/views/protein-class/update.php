<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProteinClass */

$this->title = Yii::t('common', 'Edit protein class') . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Protein Classes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="protein-class-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
