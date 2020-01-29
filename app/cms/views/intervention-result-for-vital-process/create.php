<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model cms\models\InterventionResultForVitalProcess */

$this->title = 'Добавить результат вмешательства для процесса';
$this->params['breadcrumbs'][] = ['label' => 'Intervention Result For Vital Processes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="intervention-result-for-vital-process-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
