<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GeneInterventionWay */

$this->title = Yii::t('app', 'Gene Intervention Way') . ' - ' . Yii::t('app', 'create new');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gene Intervention Ways'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gene-intervention-way-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
