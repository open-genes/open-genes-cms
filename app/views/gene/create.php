<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Gene */

$this->title = 'Добавить гены';
$this->params['breadcrumbs'][] = ['label' => 'Genes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gene-create">

    <h2><?= Html::encode($this->title) ?></h2>
    <p>
        Введите NCBI id новых генов по одному на строку
    </p>
    <div class="gene-form">
    <?php $form = ActiveForm::begin(); ?>
        <?=$form->field($model, 'newGenesNcbiIds')->textarea(['rows' => 15, 'style' => 'width: 325px'])->label(false); ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>
    </div>
</div>
