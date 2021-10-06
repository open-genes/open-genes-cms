<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StatisticalSignificance */

$this->title = Yii::t('app', 'Update Statistical Significance: {name}', [
    'name' => $model->id,
]);
$this->title = Yii::t('app', 'Statistical Significance') . ' "' . $model->name_en . '" - ' . Yii::t('app', 'update');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Statistical Significances'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="statistical-significance-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
