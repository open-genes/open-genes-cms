<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GeneInterventionMethod */
/* @var $interventionWays [] */

$this->title = Yii::t('app', 'Gene Intervention Method') . ' - ' . Yii::t('app', 'create new');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gene Intervention Methods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gene-intervention-method-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'interventionWays' => $interventionWays,
    ]) ?>

</div>
