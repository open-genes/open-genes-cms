<?php
/** @var $geneToLongevityEffect \app\models\GeneToLongevityEffect */
?>
<div class="form-split protein-activity red js-gene-to-longevity-effect js-gene-link-section"  id="genetolongevityeffect_form_<?= $geneToLongevityEffect->id ?>">
    <div class="js-gene-to-longevity-effect-block js-gene-link-block">
        <div class="form-split">
            <div class="form-split">
                <div class="form-half-without-margin">
                    <?= \kartik\select2\Select2::widget([
                        'model' => $geneToLongevityEffect,
                        'attribute' => '[' . $geneToLongevityEffect->id . ']genotype_id',
                        'data' => \app\models\Genotype::getAllNamesAsArray(),
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
                <div class="form-five-sixths">
                    <div class="form-half-without-margin">
                        <?= \kartik\select2\Select2::widget([
                            'model' => $geneToLongevityEffect,
                            'attribute' => '[' . $geneToLongevityEffect->id . ']longevity_effect_id',
                            'data' => \app\models\LongevityEffect::getAllNamesAsArray(),
                            'options' => [
                                'placeholder' => 'Эффект',
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

                    <div class="form-half-without-margin">
                        <div class="form-half-without-margin">
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
                        <div class="form-half-without-margin">
                            <?= \kartik\select2\Select2::widget([
                                'model' => $geneToLongevityEffect,
                                'attribute' => '[' . $geneToLongevityEffect->id . ']model_organism_id',
                                'data' => \app\models\ModelOrganism::getAllNamesAsArray(),
                                'options' => [
                                    'placeholder' => 'Объект',
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
                    </div>
                </div>
                <div class="form-sixth">
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
            <div class="form-half-small-margin">
                <?= \kartik\select2\Select2::widget([
                    'model' => $geneToLongevityEffect,
                    'attribute' => '[' . $geneToLongevityEffect->id . ']age_related_change_type_id',
                    'data' => \app\models\AgeRelatedChangeType::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Вид изменений',
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
            <div class="form-half-small-margin">
                <?= \yii\bootstrap\Html::activeInput('text', $geneToLongevityEffect, '[' . $geneToLongevityEffect->id . ']reference', ['class' => 'form-control', 'placeholder' => 'Ссылка в DOI формате ("10.1111/acel.12216")']) ?>
            </div>
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