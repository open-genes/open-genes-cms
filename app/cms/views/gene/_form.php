<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model cms\models\Gene */
/* @var $allFunctionalClusters [] */
/* @var $allCommentCauses [] */
/* @var $allAges[] */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile('/assets/js/gene.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('/assets/css/gene.css');

?>

<div class="gene-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'isHidden')->checkbox() ?>
    <div class="form-split">
        <div class="form-half">
            <div class="form-split">
                <div class="form-half">
                    <a class="rel-link" href="/age" target="_blank">Управление происхождением</a> <!-- todo  -->
                    <?= $form->field($model, 'age_id')->dropDownList($allAges) ?>
                </div>
                <div class="form-half">
                    <?= $form->field($model, 'expressionChange')->dropDownList([
                        '' => '',
                        'уменьшается' => 'уменьшается',
                        'увеличивается' => 'увеличивается',
                        'неоднозначно' => 'неоднозначно',
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="form-half">
          <a class="rel-link" href="/functional-cluster" target="_blank">Управление функциональными кластерами</a> <!-- todo  -->
            <?= $form->field($model, 'functionalClustersIdsArray')->widget(\kartik\select2\Select2::class, [
                'data' => $allFunctionalClusters,
                'options' => ['multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
    </div>
    <?= $form->field($model, 'commentCauseIdsArray')->widget(\kartik\select2\Select2::class, [
        'data' => $allCommentCauses,
        'options' => ['multiple' => true],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>
    <?= $form->field($model, 'commentAging')->textarea(['rows' => 4]) ?>
    <?= $form->field($model, 'commentAgingEN')->textarea(['rows' => 4]) ?>
    <?= $form->field($model, 'commentEvolution')->textarea(['rows' => 4]) ?>
    <?= $form->field($model, 'commentEvolutionEN')->textarea(['rows' => 4]) ?>
    <?= $form->field($model, 'commentFunction')->textarea(['rows' => 4]) ?>
    <?= $form->field($model, 'commentFunctionEN')->textarea(['rows' => 4]) ?>
    <?= $form->field($model, 'commentsReferenceLinks')->textarea(['rows' => 4]) ?>

    <?php if(Yii::$app->user->can('admin')): // todo add more operations to auth manager ?>

    <div class="form-split">
        <div class="form-half">
            <div class="form-split">
                <div class="form-half">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'orientation')->dropDownList([-1 => -1, 0 => 0, 1 => 1]) ?>
                    <?= $form->field($model, 'entrezGene')->textInput() ?>
                    <?= $form->field($model, 'uniprot')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="form-half">
                    <?= $form->field($model, 'symbol')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'accPromoter')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'band')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'why')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="form-half">
            <?= $form->field($model, 'aliases')->textInput(['maxlength' => true]) ?>
            <div class="form-split">
                <div class="form-half">
                    <?= $form->field($model, 'accOrf')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'locationStart')->textInput() ?>
                </div>
                <div class="form-half">
                    <?= $form->field($model, 'accCds')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'locationEnd')->textInput() ?>
                </div>
            </div>
            <?= $form->field($model, 'references')->textInput(['maxlength' => true]) ?>
        </div>
        <?= $form->field($model, 'orthologs')->textInput(['maxlength' => true]) ?>
    </div>
    <?php endif; ?>
        <div class="form-half">
            <?= $form->field($model, 'product_ru')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="form-half">
            <?= $form->field($model, 'product_en')->textInput(['maxlength' => true]) ?>
        </div>

    <br>
    <div class="form-split">
        <h4>Функции гена:</h4>
    </div>
    <div class="form-two-thirds">
        <div class="form-third">
            <label>Активность</label>
        </div>
        <div class="form-third">
            <label>Объект</label>
        </div>
        <div class="form-third">
            <label>Локализация</label>
        </div>
    </div>
    <div class="form-third">
        <label>Комментарий</label>
    </div>
    <div class="js-protein-activities">
        <?php foreach ($model->geneToProteinActivities as $geneToProteinActivity): ?>
            <?= \cms\widgets\GeneProteinActivity::widget(['geneToProteinActivity' => $geneToProteinActivity]) ?>
        <?php endforeach; ?>
    </div>
    <?= Html::button('Добавить', ['class' => 'btn js-add-protein-activity']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
