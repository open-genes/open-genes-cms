<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrganismLine */
/* @var $organismList array */

$this->title = Yii::t('common', 'Add organism line');
$this->params['breadcrumbs'][] = ['label' => 'Organism Lines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organism-line-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'organismList' => $organismList,
    ]) ?>

</div>
