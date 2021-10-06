<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\InterventionResultForVitalProcess */

$this->title = Yii::t('common', 'Add intervention result for vital process');
$this->params['breadcrumbs'][] = ['label' => 'Intervention Result For Vital Processes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="intervention-result-for-vital-process-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
