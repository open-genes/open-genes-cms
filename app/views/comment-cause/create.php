<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CommentCause */

$this->title = Yii::t('common', 'Edit comment cause');
$this->params['breadcrumbs'][] = ['label' => 'Comment Causes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-cause-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
