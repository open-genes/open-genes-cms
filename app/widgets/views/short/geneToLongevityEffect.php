<?php
/** @var $geneToLongevityEffect \app\models\GeneToLongevityEffect */
?>
<div class="js-short-form-container">
<div class="row form-row protein-activity red js-gene-to-longevity-effect js-experiment-short js-gene-link-section"
     model-name="GeneToLongevityEffect"
     widget-name="GeneToLongevityEffectWidget"
     model-id="<?= $geneToLongevityEffect->id ?>">

    <?= $geneToLongevityEffect->reference ?><br>
    Age Related Change Type: <?= $geneToLongevityEffect->ageRelatedChangeType->name_en ?><br>
    Genotype: <?= $geneToLongevityEffect->genotype->name_en ?><br>
    Longevity Effect: <?= $geneToLongevityEffect->longevityEffect->name_en ?><br>
</div>
</div>