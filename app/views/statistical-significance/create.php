<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StatisticalSignificance */

$this->title = Yii::t('app', 'Statistical Significance') . ' - ' . Yii::t('app', 'create new');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Statistical Significances'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statistical-significance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
