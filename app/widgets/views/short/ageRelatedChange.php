<?php
/** @var $ageRelatedChange \app\models\AgeRelatedChange */
?>
<div class="js-short-form-container">
    <div class="protein-activity blue js-age-related-change js-experiment-short js-gene-link-section"
         model-name="AgeRelatedChange"
         widget-name="AgeRelatedChangeWidget"
         model-id="<?= $ageRelatedChange->id ?>">
        <?= $ageRelatedChange->reference; ?><br>
        <?= $ageRelatedChange->ageRelatedChangeType->name_en; ?><br>
        <?= $ageRelatedChange->comment_en; ?><br>
    </div>
</div>