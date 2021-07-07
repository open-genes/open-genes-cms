<?php
/** @var $geneToProgeria \app\models\GeneToProgeria */
?>
<div class="protein-activity orange js-gene-to-progeria js-gene-link-section">
    <div class="js-gene-to-progeria-block js-gene-link-block">
        <div class="row form-row">
            <div class="col-xs-3 col-sm-4">
                <?= \kartik\select2\Select2::widget([
                    'model' => $geneToProgeria,
                    'attribute' => '[' . $geneToProgeria->id . ']progeria_syndrome_id',
                    'data' => \app\models\ProgeriaSyndrome::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Прогерический синдром',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'tags' => true,
                        'tokenSeparators' => ['##'],
                        'containerCssClass' => 'orange',
                        'dropdownCssClass' => 'orange',
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-3 col-sm-4">
                <?= \yii\bootstrap\Html::activeInput('text', $geneToProgeria, '[' . $geneToProgeria->id . ']reference', ['class' => 'form-control', 'placeholder' => 'DOI (пример: 10.1111/acel.12216)']) ?>
            </div>
            <div class="col-xs-3 col-sm-4">
                <?= \yii\bootstrap\Html::activeInput('text', $geneToProgeria, '[' . $geneToProgeria->id . ']pmid', ['class' => 'form-control', 'placeholder' => 'PMID (пример: 34225353)']) ?>
            </div>
        </div>
        <div class="row form-row">
            <div class="col-xs-12 col-sm-6">
                <?= \yii\bootstrap\Html::activeTextarea($geneToProgeria, '[' . $geneToProgeria->id . ']comment_ru', ['class' => 'form-control', 'placeholder' => 'Дополнительная информация']) ?>
            </div>
            <div class="col-xs-12 col-sm-6">
                <?= \yii\bootstrap\Html::activeTextarea($geneToProgeria, '[' . $geneToProgeria->id . ']comment_en', ['class' => 'form-control', 'placeholder' => 'Дополнительная информация EN']) ?>
            </div>
        </div>
    </div>
    <div class="row form-row">
        <div class="col-xs-12 delete-protein"><?= \yii\bootstrap\Html::activeCheckbox($geneToProgeria, '[' . $geneToProgeria->id . ']delete', ['class' => 'js-delete']) ?></div>
    </div>
</div>