<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ActiveSubstanceDosageUnit */

$this->title = Yii::t('common', 'Add active substance delivery way');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Add active substance delivery way'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="active-substance-dosage-unit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
