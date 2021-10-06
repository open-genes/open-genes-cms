<?php

use yii\db\Migration;

/**
 * Class m211006_143233_move_gene_intervention_to_vital_process_to_new_table
 */
class m211006_143233_move_gene_intervention_to_vital_process_to_new_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('gene_intervention_to_vital_process', 'gene_intervention_method_id', $this->integer());
        $this->addForeignKey('gene_intervention_to_vital_process_method', 'gene_intervention_to_vital_process', 'gene_intervention_method_id', 'gene_intervention_method', 'id');
        $this->execute('update gene_intervention_to_vital_process set gene_intervention_method_id = gene_intervention_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('gene_intervention_to_vital_process_method', 'gene_intervention_to_vital_process');
        $this->dropColumn('gene_intervention_to_vital_process', 'gene_intervention_method_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211006_143233_move_gene_intervention_to_vital_process_to_new_table cannot be reverted.\n";

        return false;
    }
    */
}
