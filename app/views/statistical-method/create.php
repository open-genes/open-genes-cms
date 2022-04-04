<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StatisticalMethod */

$this->title = 'Статистический анализ' . ' - ' . Yii::t('app', 'create new');
$this->params['breadcrumbs'][] = ['label' => 'Статистический анализ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statistical-method-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
