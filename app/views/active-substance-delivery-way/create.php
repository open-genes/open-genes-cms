<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ActiveSubstanceDeliveryWay */

$this->title = Yii::t('app', 'Active Substance Delivery Way') . ' - ' . Yii::t('app', 'create new');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Active Substance Delivery Ways'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="active-substance-delivery-way-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
