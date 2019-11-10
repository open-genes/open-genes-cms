<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model cms\models\CommentCause */

$this->title = 'Update Comment Cause: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Comment Causes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="comment-cause-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
