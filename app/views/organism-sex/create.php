<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrganismSex */

$this->title = Yii::t('app', 'Organism Sex') . ' - ' . Yii::t('app', 'create new');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Organism Sexes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organism-sex-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
