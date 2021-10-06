<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TreatmentTimeUnit */

$this->title = Yii::t('app', 'Treatment Time Unit') . ' - ' . Yii::t('app', 'create new');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Treatment Time Units'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="treatment-time-unit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
