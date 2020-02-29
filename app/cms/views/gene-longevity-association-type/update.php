<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model cms\models\GeneLongevityAssociationType */

$this->title = 'Редактировать тип ассоциаций с генотипами ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gene Longevity Association Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gene-longevity-association-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
