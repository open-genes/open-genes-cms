<?php
/** @var $geneToLongevityEffect \cms\models\GeneToLongevityEffect */
?>
<div class="form-split protein-activity red js-gene-to-longevity-effect js-gene-link-section">
    <div class="js-gene-to-longevity-effect-block js-gene-link-block">
        <div class="form-split">
            <div class="form-split">
                <div class="form-half-without-margin">
                    <?= \kartik\select2\Select2::widget([
                        'model' => $geneToLongevityEffect,
                        'attribute' => '[' . $geneToLongevityEffect->id . ']genotype_id',
                        'data' => \cms\models\Genotype::getAllNamesAsArray(),
                        'options' => [
                            'placeholder' => 'Аллельный полиморфизм',
                            'multiple' => false,
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'tags' => true,
                            'tokenSeparators' => ['##'],
                            'containerCssClass' => 'red',
                            'dropdownCssClass' => 'red',
                        ],
                    ]);
                    ?>
                </div>
                <div class="form-half-without-margin">
                    <?= \yii\bootstrap\Html::activeInput('text', $geneToLongevityEffect, '[' . $geneToLongevityEffect->id . ']allele_variant', ['class' => 'form-control', 'placeholder' => 'Аллельный вариант']) ?>
                </div>
            </div>
            <div class="form-split">
                <div class="form-half-without-margin">
                    <?= \kartik\select2\Select2::widget([
                        'model' => $geneToLongevityEffect,
                        'attribute' => '[' . $geneToLongevityEffect->id . ']longevity_effect_id',
                        'data' => \cms\models\LongevityEffect::getAllNamesAsArray(),
                        'options' => [
                            'placeholder' => 'Эффект',
                            'multiple' => false,
                        ],
                        'pluginOptions' => [
                            'allowClear' => false,
                            'tags' => true,
                            'tokenSeparators' => ['##'],
                            'containerCssClass' => 'red',
                            'dropdownCssClass' => 'red',
                        ],
                    ]);
                    ?>
                </div>
                <div class="form-half-without-margin">
                    <?= \kartik\select2\Select2::widget([
                        'model' => $geneToLongevityEffect,
                        'attribute' => '[' . $geneToLongevityEffect->id . ']sex_of_organism',
                        'data' => ['' => '', 0 => 'женский', 1 => 'мужской', 2 => 'оба пола'],
                        'options' => [
                            'placeholder' => 'Пол',
                            'multiple' => false
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'containerCssClass' => 'red',
                            'dropdownCssClass' => 'red',
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="form-split">
            <?= \yii\bootstrap\Html::activeInput('text', $geneToLongevityEffect, '[' . $geneToLongevityEffect->id . ']reference', ['class' => 'form-control', 'placeholder' => 'Ссылка']) ?>
        </div>
        <div class="form-split no-margin">
            <div class="form-half-small-margin">
                <?= \yii\bootstrap\Html::activeTextarea($geneToLongevityEffect, '[' . $geneToLongevityEffect->id . ']comment_ru', ['class' => 'form-control', 'placeholder' => 'Дополнительная информация']) ?>
            </div>
            <div class="form-half-small-margin">
                <?= \yii\bootstrap\Html::activeTextarea($geneToLongevityEffect, '[' . $geneToLongevityEffect->id . ']comment_en', ['class' => 'form-control', 'placeholder' => 'Дополнительная информация EN']) ?>
            </div>
        </div>
    </div>
    <div class="delete-protein"><?= \yii\bootstrap\Html::activeCheckbox($geneToLongevityEffect, '[' . $geneToLongevityEffect->id . ']delete', ['class' => 'js-delete']) ?></div>
</div>