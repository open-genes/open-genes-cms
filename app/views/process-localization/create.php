<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProcessLocalization */

$this->title = 'Добавить локализацию процесса';
$this->params['breadcrumbs'][] = ['label' => 'Process Localizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="process-localization-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
