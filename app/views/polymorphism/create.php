<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Polymorphism */

$this->title = 'Добавить аллельный полиморфизм';
$this->params['breadcrumbs'][] = ['label' => 'Polymorphism', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="genotype-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
