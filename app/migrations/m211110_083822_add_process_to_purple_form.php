<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m211110_083822_add_process_to_purple_form
 */
class m211110_083822_add_process_to_purple_form extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('general_lifespan_experiment_to_vital_process', [
            'id' => Schema::TYPE_PK,
            'general_lifespan_experiment_id' => Schema::TYPE_INTEGER,
            'intervention_result_for_vital_process_id' => Schema::TYPE_INTEGER,
            'vital_process_id' => Schema::TYPE_INTEGER,
        ]);

        $this->addForeignKey('interv_result_to_vital_pr_to_le', 'general_lifespan_experiment_to_vital_process', 'general_lifespan_experiment_id', 'general_lifespan_experiment', 'id');
        $this->addForeignKey('interv_result_for_vital_pr_id_to_res', 'general_lifespan_experiment_to_vital_process', 'intervention_result_for_vital_process_id', 'intervention_result_for_vital_process', 'id');
        $this->addForeignKey('interv_result_for_vital_pr_id_to_proc', 'general_lifespan_experiment_to_vital_process', 'vital_process_id', 'vital_process', 'id');

        $this->createIndex('interv_result_for_vital_pr_to_general',
            'general_lifespan_experiment_to_vital_process',
            ['general_lifespan_experiment_id', 'intervention_result_for_vital_process_id', 'vital_process_id'],
            true
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('interv_result_to_vital_pr_to_le', 'general_lifespan_experiment_to_vital_process');
        $this->dropForeignKey('interv_result_for_vital_pr_id_to_result', 'general_lifespan_experiment_to_vital_process');
        $this->dropForeignKey('interv_result_for_vital_pr_id_to_process', 'general_lifespan_experiment_to_vital_process');

        $this->dropTable('general_lifespan_experiment_to_vital_process');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211110_083822_add_process_to_purple_form cannot be reverted.\n";

        return false;
    }
    */
}
