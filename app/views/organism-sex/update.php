<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrganismSex */

$this->title = Yii::t('common', 'Edit organism sex') . ' - "' . $model->name_en . '"';

$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Organism sex'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="organism-sex-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
