<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AgingMechanism */

$this->title = Yii::t('app', 'Aging Mechanism') . ' - ' . Yii::t('app', 'create new');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Aging Mechanisms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aging-mechanism-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
