<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ethnicity */

$this->title = 'Этническая принадлежность' . ' - ' . Yii::t('app', 'create new');
$this->params['breadcrumbs'][] = ['label' => 'Ethnicities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ethnicity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
