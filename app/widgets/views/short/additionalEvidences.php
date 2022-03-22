<?php
/** @var $geneToAdditionalEvidence \app\models\GeneToAdditionalEvidence */
?>
<div class="js-short-form-container">
    <div class="additional-evidence protein-activity gray js-experiment-short js-additional-evidence-short js-gene-link-section"
         model-name="GeneToAdditionalEvidence"
         widget-name="AdditionalEvidencesWidget"
         model-id="<?= $geneToAdditionalEvidence->id ?>">
        <?= $geneToAdditionalEvidence->comment_en; ?>
    </div>
</div>