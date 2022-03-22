<?php
/** @var $proteinToGene \app\models\ProteinToGene */
?>
<div class="protein-activity yellow js-protein-to-gene js-gene-link-section">
    <div class="js-protein-to-gene-block js-gene-link-block">
        <div class="row form-row">
            <div class="col-xs-12 col-sm-6">
                <?= \kartik\select2\Select2::widget([
                    'model' => $proteinToGene,
                    'attribute' => '[' . $proteinToGene->id . ']protein_activity_id',
                    'data' => \app\models\ProteinActivity::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Активность',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'tags' => Yii::$app->user->can('admin'),
                        'tokenSeparators' => ['##'],
                        'containerCssClass' => 'yellow',
                        'dropdownCssClass' => 'yellow',
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-12 col-sm-6">
                <?= \kartik\select2\Select2::widget([
                    'model' => $proteinToGene,
                    'attribute' => '[' . $proteinToGene->id . ']regulated_gene_id',
                    'data' => \app\models\Gene::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Регулируемый ген',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'tokenSeparators' => ['##'],
                        'containerCssClass' => 'yellow',
                        'dropdownCssClass' => 'yellow',
                    ],
                ]);
                ?>
            </div>
        </div>
        <div class="row form-row">
            <div class="col-xs-4">
                <?= \kartik\select2\Select2::widget([
                    'model' => $proteinToGene,
                    'attribute' => '[' . $proteinToGene->id . ']regulation_type_id',
                    'data' => app\models\GeneRegulationType::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Вид регуляции',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'tags' => Yii::$app->user->can('admin'),
                        'tokenSeparators' => ['##'],
                        'containerCssClass' => 'yellow',
                        'dropdownCssClass' => 'yellow',
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-4">
                <?= \yii\bootstrap\Html::activeInput('text', $proteinToGene, '[' . $proteinToGene->id . ']reference', ['class' => 'form-control', 'placeholder' => 'DOI (пример: 10.1111/acel.12216)']) ?>
            </div>
            <div class="col-xs-4">
                <?= \yii\bootstrap\Html::activeInput('text', $proteinToGene, '[' . $proteinToGene->id . ']pmid', ['class' => 'form-control', 'placeholder' => 'PMID (пример: 34225353)']) ?>
            </div>
        </div>
        <div class="row form-row">
            <div class="col-xs-12">
                <?= \yii\bootstrap\Html::activeTextarea($proteinToGene, '[' . $proteinToGene->id . ']comment_ru', ['class' => 'form-control', 'placeholder' => 'Дополнительная информация']) ?>
            </div>
            <div class="col-xs-12">
                <?= \yii\bootstrap\Html::activeTextarea($proteinToGene, '[' . $proteinToGene->id . ']comment_en', ['class' => 'form-control', 'placeholder' => 'Дополнительная информация EN']) ?>
            </div>
        </div>
    </div>
    <div class="row form-row">
        <div class="col-xs-12 delete-protein"><?= \yii\bootstrap\Html::activeCheckbox($proteinToGene, '[' . $proteinToGene->id . ']delete', ['class' => 'js-delete']) ?></div>
    </div>
</div>