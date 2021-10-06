<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VitalProcess */

$this->title = Yii::t('common', 'Add vital process');
$this->params['breadcrumbs'][] = ['label' => 'Vital Processes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vital-process-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
