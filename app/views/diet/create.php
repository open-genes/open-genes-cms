<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Diet */

$this->title = 'Диета' . ' - ' . Yii::t('app', 'create new');
$this->params['breadcrumbs'][] = ['label' => 'Diet', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="genotype-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
