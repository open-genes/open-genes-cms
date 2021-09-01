<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LifespanExperimentLink */

$this->title = Yii::t('app', 'Lifespan Experiment Link') . ' - ' . Yii::t('app', 'create new');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lifespan Experiment Links'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lifespan-experiment-link-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
