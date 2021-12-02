<?php

use yii\db\Migration;

/**
 * Class m211202_153354_delete_cascade_green_and_purple_forms
 */
class m211202_153354_delete_cascade_green_and_purple_forms extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('interv_result_to_vital_pr_to_form', 'gene_intervention_result_to_vital_process');
        $this->dropForeignKey('interv_result_for_vital_pr_id_to_result', 'gene_intervention_result_to_vital_process');
        $this->dropForeignKey('interv_result_for_vital_pr_id_to_process', 'gene_intervention_result_to_vital_process');

        $this->addForeignKey('interv_result_to_vital_pr_to_form', 'gene_intervention_result_to_vital_process', 'gene_intervention_to_vital_process_id', 'gene_intervention_to_vital_process', 'id', 'CASCADE');
        $this->addForeignKey('interv_result_for_vital_pr_id_to_result', 'gene_intervention_result_to_vital_process', 'intervention_result_for_vital_process_id', 'intervention_result_for_vital_process', 'id', 'CASCADE');
        $this->addForeignKey('interv_result_for_vital_pr_id_to_process', 'gene_intervention_result_to_vital_process', 'vital_process_id', 'vital_process', 'id', 'CASCADE');


        $this->dropForeignKey('interv_result_to_vital_pr_to_le', 'general_lifespan_experiment_to_vital_process');
        $this->dropForeignKey('interv_result_for_vital_pr_id_to_res', 'general_lifespan_experiment_to_vital_process');
        $this->dropForeignKey('interv_result_for_vital_pr_id_to_proc', 'general_lifespan_experiment_to_vital_process');

        $this->addForeignKey('interv_result_to_vital_pr_to_le', 'general_lifespan_experiment_to_vital_process', 'general_lifespan_experiment_id', 'general_lifespan_experiment', 'id', 'CASCADE');
        $this->addForeignKey('interv_result_for_vital_pr_id_to_res', 'general_lifespan_experiment_to_vital_process', 'intervention_result_for_vital_process_id', 'intervention_result_for_vital_process', 'id', 'CASCADE');
        $this->addForeignKey('interv_result_for_vital_pr_id_to_proc', 'general_lifespan_experiment_to_vital_process', 'vital_process_id', 'vital_process', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('interv_result_to_vital_pr_to_form', 'gene_intervention_result_to_vital_process');
        $this->dropForeignKey('interv_result_for_vital_pr_id_to_result', 'gene_intervention_result_to_vital_process');
        $this->dropForeignKey('interv_result_for_vital_pr_id_to_process', 'gene_intervention_result_to_vital_process');

        $this->addForeignKey('interv_result_to_vital_pr_to_form', 'gene_intervention_result_to_vital_process', 'gene_intervention_to_vital_process_id', 'gene_intervention_to_vital_process', 'id');
        $this->addForeignKey('interv_result_for_vital_pr_id_to_result', 'gene_intervention_result_to_vital_process', 'intervention_result_for_vital_process_id', 'intervention_result_for_vital_process', 'id');
        $this->addForeignKey('interv_result_for_vital_pr_id_to_process', 'gene_intervention_result_to_vital_process', 'vital_process_id', 'vital_process', 'id');

        $this->dropForeignKey('interv_result_to_vital_pr_to_le', 'general_lifespan_experiment_to_vital_process');
        $this->dropForeignKey('interv_result_for_vital_pr_id_to_res', 'general_lifespan_experiment_to_vital_process');
        $this->dropForeignKey('interv_result_for_vital_pr_id_to_proc', 'general_lifespan_experiment_to_vital_process');

        $this->addForeignKey('interv_result_to_vital_pr_to_le', 'general_lifespan_experiment_to_vital_process', 'general_lifespan_experiment_id', 'general_lifespan_experiment', 'id');
        $this->addForeignKey('interv_result_for_vital_pr_id_to_res', 'general_lifespan_experiment_to_vital_process', 'intervention_result_for_vital_process_id', 'intervention_result_for_vital_process', 'id');
        $this->addForeignKey('interv_result_for_vital_pr_id_to_proc', 'general_lifespan_experiment_to_vital_process', 'vital_process_id', 'vital_process', 'id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211202_150822_delete_cascade_green_form cannot be reverted.\n";

        return false;
    }
    */
}
