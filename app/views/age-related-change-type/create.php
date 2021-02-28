<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model cms\models\AgeRelatedChangeType */

$this->title = 'Добавить вид возрастных изменений гена/белка';
$this->params['breadcrumbs'][] = ['label' => 'Age Related Change Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="age-related-change-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
