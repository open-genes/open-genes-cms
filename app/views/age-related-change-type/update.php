<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AgeRelatedChangeType */

$this->title = Yii::t('common', 'Edit age related change type') . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Age Related Change Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="age-related-change-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
