<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model cms\models\LongevityEffect */

$this->title = 'Добавить эффект продолжительности жизни';
$this->params['breadcrumbs'][] = ['label' => 'Longevity Effects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="longevity-effect-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
