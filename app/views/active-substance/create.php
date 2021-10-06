<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ActiveSubstance */

$this->title = Yii::t('common', 'Add active substance');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Active Substances'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="active-substance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
