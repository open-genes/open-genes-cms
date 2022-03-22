<?php
/** @var $geneToProgeria \app\models\GeneToProgeria */
?>
<div class="js-short-form-container">
<div class="protein-activity orange js-gene-to-progeria js-experiment-short js-gene-link-section"
     model-name="GeneToProgeria"
     widget-name="GeneToProgeriaWidget"
     model-id="<?= $geneToProgeria->id ?>">
    <?= $geneToProgeria->reference ?><br>
    Syndrom: <?= $geneToProgeria->progeriaSyndrome->name_en ?><br>
</div>
</div>