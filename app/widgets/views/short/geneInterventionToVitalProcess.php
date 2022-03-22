<?php
/** @var $geneInterventionToVitalProcess \app\models\GeneInterventionToVitalProcess */

use app\models\InterventionResultForVitalProcess;

?>
<div class="js-short-form-container">
    <div class="protein-activity green js-intervention-to-vital-process js-experiment-short js-gene-link-section"
         model-name="GeneInterventionToVitalProcess"
         widget-name="GeneInterventionToVitalProcessWidget"
         model-id="<?= $geneInterventionToVitalProcess->id ?>">
        <?= $geneInterventionToVitalProcess->reference ?><br>
         Intervention Method: <?= $geneInterventionToVitalProcess->geneInterventionMethod->name_en ?><br>
         Intervention: <?= $geneInterventionToVitalProcess->geneIntervention->name_en ?><br>
    </div>
</div>