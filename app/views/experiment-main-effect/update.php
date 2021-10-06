<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ExperimentMainEffect */

$this->title = Yii::t('app', 'Experiment main effects') . ' "' . $model->name_en . '"';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Experiment Main Effects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="experiment-main-effect-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
