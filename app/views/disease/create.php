<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\common\Disease */

$this->title = Yii::t('common', 'Add disease');
$this->params['breadcrumbs'][] = ['label' => 'Diseases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disease-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
