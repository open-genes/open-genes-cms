<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LifespanExperimentToTissue */

$this->title = Yii::t('app', 'Lifespan Experiment To Tissue') . ' - ' . Yii::t('app', 'create new');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Lifespan Experiment To Tissues'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lifespan-experiment-to-tissue-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
