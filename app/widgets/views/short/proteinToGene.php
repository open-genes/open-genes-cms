<?php
/** @var $proteinToGene \app\models\ProteinToGene */
?>
<div class="js-short-form-container">
    <div class="protein-activity yellow js-protein-to-gene js-experiment-short js-gene-link-section"
         model-name="ProteinToGene"
         widget-name="ProteinToGeneWidget"
         model-id="<?= $proteinToGene->id ?>">
        <?= $proteinToGene->reference ?><br>
        Protein Activity: <?= $proteinToGene->proteinActivity->name_en ?><br>
        Regulated Gene: <?= $proteinToGene->regulatedGene->symbol ?><br>
    </div>
</div>