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
        <?= $generalLifespanExperiment->organismLine->name_en ?><br><br>
        Результат: 
        <br>
        <?= $generalLifespanExperiment->interventionResult->name_en ?><br><br>
        Воздействия в контроле и эксперименте:
        <br>
        <?php foreach ($generalLifespanExperiment->getLifespanExperimentsForForm('control', $currentGeneId) as $lifespanExperiment) {
            echo $lifespanExperiment->geneInterventionMethod->name_en . '<br>';
        } ?><br>
        Воздействия в эксперименте:
        <br>
        <?php foreach ($generalLifespanExperiment->getLifespanExperimentsForForm('experiment') as $lifespanExperiment) {

            echo $lifespanExperiment->geneInterventionMethod->name_en . '<br>';

        } ?>
        
    </div>
</div>

