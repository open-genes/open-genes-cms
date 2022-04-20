<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PolymorphismType */

$this->title = 'Вид полиморфизма' . ' - ' . Yii::t('app', 'create new');
$this->params['breadcrumbs'][] = ['label' => 'Polymorphism Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="polymorphism-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
