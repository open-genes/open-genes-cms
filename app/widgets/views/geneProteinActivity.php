<?php
/** @var $geneToProteinActivity \app\models\GeneToProteinActivity */
?>
<div class="protein-activity js-protein-activity js-gene-link-section">
    <div class="js-protein-activity-block js-gene-link-block">
        <div class="row form-row">
            <div class="col-xs-6 col-sm-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $geneToProteinActivity,
                    'attribute' => '[' . $geneToProteinActivity->id . ']protein_activity_id',
                    'data' => \app\models\ProteinActivity::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Активность',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'tags' => true,
                        'tokenSeparators' => ['##'],
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-6 col-sm-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $geneToProteinActivity,
                    'attribute' => '[' . $geneToProteinActivity->id . ']protein_activity_object_id',
                    'data' => \app\models\ProteinActivityObject::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Объект',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'tags' => true,
                        'tokenSeparators' => ['##'],
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-6 col-sm-3">
                <?= \kartik\select2\Select2::widget([
                    'model' => $geneToProteinActivity,
                    'attribute' => '[' . $geneToProteinActivity->id . ']process_localization_id',
                    'data' => \app\models\ProcessLocalization::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Локализация',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'tags' => true,
                        'tokenSeparators' => ['##'],
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-6 col-sm-3">
                <?= \yii\bootstrap\Html::activeInput('text', $geneToProteinActivity,
                    '[' . $geneToProteinActivity->id . ']reference',
                    ['class' => 'form-control', 'placeholder' => 'Ссылка в DOI формате ("10.1111/acel.12216")'])
                ?>
            </div>
        </div>

        <div class="row form-row">
            <div class="col-xs-12 col-sm-6">
                <?= \yii\bootstrap\Html::activeTextarea($geneToProteinActivity,
                    '[' . $geneToProteinActivity->id . ']comment_ru',
                    ['class' => 'form-control', 'placeholder' => 'Комментарий'])
                ?>
            </div>
            <div class="col-xs-12 col-sm-6">
                <?= \yii\bootstrap\Html::activeTextarea($geneToProteinActivity,
                    '[' . $geneToProteinActivity->id . ']comment_en',
                    ['class' => 'form-control', 'placeholder' => 'Комментарий EN'])
                ?>
            </div>
        </div>
    </div>

    <div class="row form-row">
        <div class="col-xs-12 delete-protein"><?= \yii\bootstrap\Html::activeCheckbox($geneToProteinActivity, '[' . $geneToProteinActivity->id . ']delete', ['class' => 'js-delete']) ?></div>
    </div>
</div>