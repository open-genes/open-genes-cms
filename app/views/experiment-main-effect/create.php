<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ExperimentMainEffect */

$this->title = Yii::t('common', 'Add experiment main effects');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Experiment Main Effects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="experiment-main-effect-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
