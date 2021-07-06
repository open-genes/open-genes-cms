<?php
/** @var $geneToAdditionalEvidence \app\models\GeneToAdditionalEvidence */
?>
<div class="additional-evidence protein-activity gray js-additional-evidence js-gene-link-section">
    <div class="js-additional-evidence-block js-gene-link-block">
        <div class="row form-row">
            <div class="col-xs-12 col-sm-6">
                <?= \yii\bootstrap\Html::activeTextarea($geneToAdditionalEvidence,
                    '[' . $geneToAdditionalEvidence->id . ']comment_en',
                    ['class' => 'form-control', 'placeholder' => 'Обоснование ассоциации EN'])
                ?>
            </div>

            <div class="col-xs-12 col-sm-6">
                <?= \yii\bootstrap\Html::activeTextarea($geneToAdditionalEvidence,
                    '[' . $geneToAdditionalEvidence->id . ']comment_ru',
                    ['class' => 'form-control', 'placeholder' => 'Обоснование ассоциации'])
                ?>
            </div>
        </div>

        <div class="row form-row">
            <div class="col-xs-12 col-sm-6">
                <?= \yii\bootstrap\Html::activeInput('text', $geneToAdditionalEvidence,
                    '[' . $geneToAdditionalEvidence->id . ']reference',
                    ['class' => 'form-control', 'placeholder' => 'Ссылка в DOI формате ("10.1111/acel.12216")'])
                ?>
            </div>
        </div>

        <div class="row form-row">
            <div class="col-xs-12 delete-protein"><?= \yii\bootstrap\Html::activeCheckbox($geneToAdditionalEvidence, '[' . $geneToAdditionalEvidence->id . ']delete', ['class' => 'js-delete']) ?></div>
        </div>
    </div>
</div>