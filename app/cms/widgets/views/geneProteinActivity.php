<?php
/** @var $geneToProteinActivity \cms\models\GeneToProteinActivity */
?>
<div class="form-split protein-activity js-protein-activity">
    <div class="js-protein-activity-block">
        <div class="form-split">
            <div class="form-third">
                <?= \kartik\select2\Select2::widget([
                    'model' => $geneToProteinActivity,
                    'attribute' => '[' . $geneToProteinActivity->id . ']protein_activity_id',
                    'data' => \cms\models\ProteinActivity::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Активность',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'tags' => true,
                        'tokenSeparators' => [','],
                    ],
                ]);
                ?>
            </div>
            <div class="form-third">
                <?= \kartik\select2\Select2::widget([
                    'model' => $geneToProteinActivity,
                    'attribute' => '[' . $geneToProteinActivity->id . ']protein_activity_object_id',
                    'data' => \cms\models\ProteinActivityObject::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Объект',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'tags' => true,
                        'tokenSeparators' => [','],
                    ],
                ]);
                ?>
            </div>
            <div class="form-third">
                <?= \kartik\select2\Select2::widget([
                    'model' => $geneToProteinActivity,
                    'attribute' => '[' . $geneToProteinActivity->id . ']process_localization_id',
                    'data' => \cms\models\ProcessLocalization::getAllNamesAsArray(),
                    'options' => [
                        'placeholder' => 'Локализация',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'tags' => true,
                        'tokenSeparators' => [','],
                    ],
                ]);
                ?>
            </div>
        </div>
        <div class="form-split">
            <div class="form-half-small-margin">
                <?= \yii\bootstrap\Html::activeTextarea($geneToProteinActivity, '[' . $geneToProteinActivity->id . ']comment_ru', ['class' => 'form-control', 'placeholder' => 'Комментарий']) ?>
            </div>
            <div class="form-half-small-margin">
                <?= \yii\bootstrap\Html::activeTextarea($geneToProteinActivity, '[' . $geneToProteinActivity->id . ']comment_en', ['class' => 'form-control', 'placeholder' => 'Комментарий EN']) ?>
            </div>
        </div>
    </div>
    <div class="delete-protein"><?= \yii\bootstrap\Html::activeCheckbox($geneToProteinActivity, '[' . $geneToProteinActivity->id . ']delete', ['class' => 'js-delete']) ?></div>
</div>