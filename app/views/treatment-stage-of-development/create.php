<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TreatmentStageOfDevelopment */

$this->title = Yii::t('app', 'Treatment Stage Of Development') . ' - ' . Yii::t('app', 'create new');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Treatment Stage Of Developments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="treatment-stage-of-development-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
