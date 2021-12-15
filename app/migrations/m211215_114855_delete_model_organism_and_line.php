<?php

use yii\db\Migration;

/**
 * Class m211215_114855_delete_model_organism_and_line
 */
class m211215_114855_delete_model_organism_and_line extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('age_related_change_model_organism', 'age_related_change');
        $this->addForeignKey('age_related_change_model_organism', 'age_related_change', 'model_organism_id', 'model_organism', 'id', 'CASCADE');

        $this->dropForeignKey('model_organism_id_model_organism', 'organism_line');
        $this->addForeignKey(
            'model_organism_id_model_organism',
            'organism_line',
            'model_organism_id',
            'model_organism',
            'id',
            'CASCADE'
        );

        $this->dropForeignKey('age_related_change_organism_line', 'age_related_change');
        $this->addForeignKey('age_related_change_organism_line', 'age_related_change', 'organism_line_id', 'organism_line', 'id', 'CASCADE');

        $this->dropForeignKey('interv_to_vital_pr_organism_line', 'gene_intervention_to_vital_process');
        $this->addForeignKey('interv_to_vital_pr_organism_line', 'gene_intervention_to_vital_process', 'organism_line_id', 'organism_line', 'id', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('interv_to_vital_pr_organism_line', 'gene_intervention_to_vital_process');
        $this->addForeignKey('interv_to_vital_pr_organism_line', 'gene_intervention_to_vital_process', 'organism_line_id', 'organism_line', 'id');

        $this->dropForeignKey('age_related_change_organism_line', 'age_related_change');
        $this->addForeignKey('age_related_change_organism_line', 'age_related_change', 'organism_line_id', 'organism_line', 'id');

        $this->dropForeignKey('age_related_change_model_organism', 'age_related_change');
        $this->addForeignKey('age_related_change_model_organism', 'age_related_change', 'model_organism_id', 'model_organism', 'id');

        $this->dropForeignKey('model_organism_id_model_organism', 'organism_line');
        $this->addForeignKey(
            'model_organism_id_model_organism',
            'organism_line',
            'model_organism_id',
            'model_organism',
            'id'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211215_114855_delete_model_organism_and_line cannot be reverted.\n";

        return false;
    }
    */
}
