<?php
/** @var $generalLifespanExperiment \app\models\GeneralLifespanExperiment */
/** @var $currentLifespanExperiment \app\models\LifespanExperiment */
/** @var $currentGeneId int */
?>

<div class="js-short-form-container">
    <div class="protein-activity js-lifespan-experiment-short js-gene-link-section"
         model-name="LifespanExperiment"
         model-id="<?= $currentLifespanExperiment->id ?>"
         gene-id="<?= $currentGeneId ?>"
    >
        <div style="float: right">
        <?= $generalLifespanExperiment->reference ?><br>
        <?= $generalLifespanExperiment->modelOrganism->name_en ?>
        <?= $generalLifespanExperiment->organismLine->name_en ?>
        </div>
        Воздействие:<br>
        <?php foreach ($generalLifespanExperiment->getLifespanExperimentsForForm('experiment') as $lifespanExperiment) {
            if ($lifespanExperiment->gene_id == $currentGeneId) {
                echo $lifespanExperiment->geneInterventionMethod->name_en . '<br>';
                echo $lifespanExperiment->experimentMainEffect->name_en . '<br>';
            }
        } ?>

        <?php
        $controlLifespanExperiments = $generalLifespanExperiment->getLifespanExperimentsForForm('control', $currentGeneId);
        if ($controlLifespanExperiments) {
            echo '<br> Доп. воздействия в контроле и эксперименте: ';
            foreach ($controlLifespanExperiments as $controlLifespanExperiment) {
                echo $controlLifespanExperiment->gene->symbol . '<br>';
                echo $controlLifespanExperiment->geneInterventionMethod->name_en . '<br>';
                echo $controlLifespanExperiment->experimentMainEffect->name_en . '<br>';
            }
        }
         ?>
        <?php
        $lifespanExperiments = $generalLifespanExperiment->getLifespanExperimentsForForm('experiment', $currentGeneId, true);
        if($lifespanExperiments) {
            echo '<br>Доп. воздействия в эксперименте: ';
            foreach ($lifespanExperiments as $lifespanExperiment) {
                echo $lifespanExperiment->gene->symbol . '<br>';
                echo $lifespanExperiment->geneInterventionMethod->name_en . '<br>';
                echo $lifespanExperiment->experimentMainEffect->name_en . '<br>';
            }
        }
         ?>
        <br>
        Результат:
        <br>
        <?= $generalLifespanExperiment->interventionResult->name_en ?><br><br>
    </div>
</div>

