<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model cms\models\CommentCause */

$this->title = 'Create Comment Cause';
$this->params['breadcrumbs'][] = ['label' => 'Comment Causes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-cause-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
