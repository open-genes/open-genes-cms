<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ExpressionEvaluation */

$this->title = 'Оценка экспрессии по ' . ' - ' . Yii::t('app', 'create new');
$this->params['breadcrumbs'][] = ['label' => 'Оценка экспрессии по ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expression-evaluation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
