<?php

use yii\db\Migration;

/**
 * Class m211230_111744_delete_cascade_gene_intervention_method
 */
class m211230_111744_delete_cascade_gene_intervention_method extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('lifespan_experiment_gene_intervention_method', 'lifespan_experiment');
        $this->addForeignKey('lifespan_experiment_gene_intervention_method', 'lifespan_experiment', 'gene_intervention_method_id', 'gene_intervention_method', 'id', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('lifespan_experiment_gene_intervention_method', 'lifespan_experiment');
        $this->addForeignKey('lifespan_experiment_gene_intervention_method', 'lifespan_experiment', 'gene_intervention_method_id', 'gene_intervention_method', 'id');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211230_111744_delete_cascade_gene_intervention_method cannot be reverted.\n";

        return false;
    }
    */
}
