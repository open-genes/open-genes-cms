<?php
/** @var $generalLifespanExperiment \app\models\GeneralLifespanExperiment */
/** @var $currentGeneId int */
?>

<div class="js-short-form-container">
    <div class="protein-activity js-lifespan-experiment-short js-gene-link-section"
         model-name="<?= $generalLifespanExperiment->id ?>"
         model-id="<?= $generalLifespanExperiment->id ?>"
         gene-id="<?= $currentGeneId ?>"
    >
        <?= $generalLifespanExperiment->reference ?><br>
        <?= $generalLifespanExperiment->modelOrganism->name_en ?>
        <?= $generalLifespanExperiment->organismLine->name_en ?><br>
        <?php
        foreach ($generalLifespanExperiment->lifespanExperiments as $lifespanExperiment) {
            echo 'intervention: ' . $lifespanExperiment->geneIntervention->name_en . '<br>';
            echo 'intervention method: ' . $lifespanExperiment->geneInterventionMethod->name_en . '<br>';
        }
        ?>
    </div>
</div>
