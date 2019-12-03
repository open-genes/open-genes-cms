<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model cms\models\ProcessLocalization */

$this->title = 'Update Process Localization: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Process Localizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="process-localization-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
