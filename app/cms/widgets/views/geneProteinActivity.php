<?php
/** @var $geneToProteinActivity \cms\models\GeneToProteinActivity */
?>
<div class="form-split protein-activity js-protein-activity">
    <div class="form-two-thirds">
        <div class="form-third">
            <?=\kartik\select2\Select2::widget([
                'model' => $geneToProteinActivity,
                'attribute' => '[' . $geneToProteinActivity->id . ']protein_activity_id',
                'data' => \cms\models\ProteinActivity::getAllNamesAsArray(),
                'options' => [
                    'placeholder' => 'что делает',
                    'multiple' => false
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]);
            ?>
        </div>
        <div class="form-third">
            <?=\kartik\select2\Select2::widget([
                'model' => $geneToProteinActivity,
                'attribute' => '[' . $geneToProteinActivity->id . ']protein_activity_object_id',
                'data' => \cms\models\ProteinActivityObject::getAllNamesAsArray(),
                'options' => [
                    'placeholder' => 'с чем',
                    'multiple' => false
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="form-third">
            <?=\kartik\select2\Select2::widget([
                'model' => $geneToProteinActivity,
                'attribute' => '[' . $geneToProteinActivity->id . ']process_localization_id',
                'data' => \cms\models\ProcessLocalization::getAllNamesAsArray(),
                'options' => [
                    'placeholder' => 'где',
                    'multiple' => false
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
    </div>
    <div class="form-third">
            <?= \yii\bootstrap\Html::activeTextarea($geneToProteinActivity, '[' . $geneToProteinActivity->id . ']comment', ['class' => 'form-control']) ?>
    </div>
</div>