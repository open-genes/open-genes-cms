<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model cms\models\GeneLongevityAssociationType */

$this->title = 'Добавить тип ассоциаций с генотипами';
$this->params['breadcrumbs'][] = ['label' => 'Gene Longevity Association Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gene-longevity-association-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
