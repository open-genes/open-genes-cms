<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Genotype */

$this->title = Yii::t('common', 'Add genotype');
$this->params['breadcrumbs'][] = ['label' => 'Genotypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="genotype-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
