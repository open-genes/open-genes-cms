<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProteinClass */

$this->title = Yii::t('common', 'Add protein class');
$this->params['breadcrumbs'][] = ['label' => 'Protein Classes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="protein-class-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
