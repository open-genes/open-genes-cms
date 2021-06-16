<?php
/** @var $geneToProgeria \app\models\GeneToProgeria */
?>
<div class="form-split protein-activity orange js-gene-to-progeria js-gene-link-section">
    <div class="js-gene-to-progeria-block js-gene-link-block">
        <div class="form-split">
            <div class="form-half-small-margin">
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
            <div class="form-half-small-margin">
                <?= \yii\bootstrap\Html::activeInput('text', $geneToProgeria, '[' . $geneToProgeria->id . ']reference', ['class' => 'form-control', 'placeholder' => 'Ссылка в DOI формате ("10.1111/acel.12216")']) ?>
            </div>
        </div>
        <div class="form-split no-margin">
            <div class="form-half-small-margin">
                <?= \yii\bootstrap\Html::activeTextarea($geneToProgeria, '[' . $geneToProgeria->id . ']comment_ru', ['class' => 'form-control', 'placeholder' => 'Дополнительная информация']) ?>
            </div>
            <div class="form-half-small-margin">
                <?= \yii\bootstrap\Html::activeTextarea($geneToProgeria, '[' . $geneToProgeria->id . ']comment_en', ['class' => 'form-control', 'placeholder' => 'Дополнительная информация EN']) ?>
            </div>
        </div>
    </div>
    <div class="delete-protein"><?= \yii\bootstrap\Html::activeCheckbox($geneToProgeria, '[' . $geneToProgeria->id . ']delete', ['class' => 'js-delete']) ?></div>
</div>