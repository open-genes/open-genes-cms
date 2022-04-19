<?php
/** @var $geneToLongevityEffect \app\models\GeneToLongevityEffect */
?>
<div class="row form-row protein-activity red js-gene-to-longevity-effect js-gene-link-section">
    <div class="js-gene-to-longevity-effect-block js-gene-link-block">
        <div class="row form-row">
            <div class="col-xs-6 col-sm-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $geneToLongevityEffect,
                    'attribute' => '[' . $geneToLongevityEffect->id . ']data_type',
                    'data' => [1 => 'геномные', 2 => 'транскриптомные', 3 => 'протеомные'],
                    'options' => [
                        'placeholder' => 'Вид данных',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'containerCssClass' => 'red',
                        'dropdownCssClass' => 'red',
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-6 col-sm-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $geneToLongevityEffect,
                    'attribute' => '[' . $geneToLongevityEffect->id . ']longevity_effect_id',
                    'data' => \app\models\LongevityEffect::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Фенотип',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'tags' => Yii::$app->user->can('admin'),
                        'tokenSeparators' => ['##'],
                        'containerCssClass' => 'red',
                        'dropdownCssClass' => 'red',
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-6 col-sm-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $geneToLongevityEffect,
                    'attribute' => '[' . $geneToLongevityEffect->id . ']polymorphism_id',
                    'data' => \app\models\Polymorphism::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Полиморфизм ID',
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
            <div class="col-xs-6 col-sm-3">
                <?= \yii\bootstrap\Html::activeInput(
                        'text', $geneToLongevityEffect,
                        '[' . $geneToLongevityEffect->id . ']allele_variant',
                        ['class' => 'form-control', 'placeholder' => 'Ассоциированный аллель/генотип'])
                ?>
            </div>
        </div>
        <div class="row form-row">
            <div class="col-xs-6 col-sm-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $geneToLongevityEffect,
                    'attribute' => '[' . $geneToLongevityEffect->id . ']age_related_change_type_id',
                    'data' => \app\models\AgeRelatedChangeType::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Характеристики транскриптома/протеома',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'tags' => Yii::$app->user->can('admin'),
                        'tokenSeparators' => ['##'],
                        'containerCssClass' => 'red',
                        'dropdownCssClass' => 'red',
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-6 col-sm-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $geneToLongevityEffect,
                    'attribute' => '[' . $geneToLongevityEffect->id . ']sex_of_organism',
                    'data' => \app\models\OrganismSex::getAllNamesAsArray(),
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
            <div class="col-xs-6 col-sm-3">
                <?= \yii\bootstrap\Html::activeInput('text', $geneToLongevityEffect, '[' . $geneToLongevityEffect->id . ']nucleotide_change', ['class' => 'form-control', 'placeholder' => 'Нуклеотидная замена']) ?>
            </div>
            <div class="col-xs-6 col-sm-3">
                <?= \yii\bootstrap\Html::activeInput('text', $geneToLongevityEffect, '[' . $geneToLongevityEffect->id . ']amino_acid_change', ['class' => 'form-control', 'placeholder' => 'Аминокислотная замена']) ?>
            </div>
        </div>
        <!--test -->
        <div class="row form-row">
            <div class="col-xs-6 col-sm-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $geneToLongevityEffect,
                    'attribute' => '[' . $geneToLongevityEffect->id . ']position_id',
                    'data' => \app\models\Position::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Позиция',
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

        <div class="row form-row">
            <div class="col-xs-12 col-sm-6">
                <?= \yii\bootstrap\Html::activeInput('text', $geneToLongevityEffect, '[' . $geneToLongevityEffect->id . ']reference', ['class' => 'form-control', 'placeholder' => 'DOI (пример: 10.1111/acel.12216)']) ?>
            </div>
            <div class="col-xs-12 col-sm-6">
                <?= \yii\bootstrap\Html::activeInput('text', $geneToLongevityEffect, '[' . $geneToLongevityEffect->id . ']pmid', ['class' => 'form-control', 'placeholder' => 'PMID (пример: 34225353)']) ?>
            </div>
        </div>

        <div class="row form-row">
            <div class="col-xs-12 col-sm-6">
                <?= \yii\bootstrap\Html::activeTextarea($geneToLongevityEffect, '[' . $geneToLongevityEffect->id . ']comment_ru', ['class' => 'form-control', 'placeholder' => 'Дополнительная информация']) ?>
            </div>
            <div class="col-xs-12 col-sm-6">
                <?= \yii\bootstrap\Html::activeTextarea($geneToLongevityEffect, '[' . $geneToLongevityEffect->id . ']comment_en', ['class' => 'form-control', 'placeholder' => 'Дополнительная информация EN']) ?>
            </div>
        </div>
    </div>

    <div class="row form-row">
        <div class="col-xs-12 delete-protein"><?= \yii\bootstrap\Html::activeCheckbox($geneToLongevityEffect, '[' . $geneToLongevityEffect->id . ']delete', ['class' => 'js-delete']) ?></div>
    </div>
</div>