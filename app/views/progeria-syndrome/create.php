<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProgeriaSyndrome */

$this->title = 'Добавить прогероидный синдром';
$this->params['breadcrumbs'][] = ['label' => 'Progeria Syndromes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="progeria-syndrome-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
