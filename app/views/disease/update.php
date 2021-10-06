<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\common\Disease */

$this->title = Yii::t('common', 'Edit disease') . ' ' . $model->name_en;
$this->params['breadcrumbs'][] = ['label' => 'Diseases', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="disease-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
