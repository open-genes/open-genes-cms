<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model cms\models\CommentCause */

$this->title = 'Редактировать причину отбора ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Comment Causes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="comment-cause-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
