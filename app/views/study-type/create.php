<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StudyType */

$this->title = 'Тип исследования' . ' - ' . Yii::t('app', 'create new');
$this->params['breadcrumbs'][] = ['label' => 'Study Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="study-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
