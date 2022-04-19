<?php

use yii\db\Migration;

/**
 * Class m220407_111557_deprecated_fields_remove_lifespan_experiment
 */
class m220407_111557_deprecated_fields_remove_lifespan_experiment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('lifespan_experiment_intervention_result', 'lifespan_experiment');
        $this->dropForeignKey('lifespan_experiment_model_organism', 'lifespan_experiment');
        $this->dropForeignKey('lifespan_experiment_organism_line', 'lifespan_experiment');

        $this->dropColumn('lifespan_experiment', 'organism_line_id');
        $this->dropColumn('lifespan_experiment', 'intervention_result_id');
        $this->dropColumn('lifespan_experiment', 'model_organism_id');

        $this->addForeignKey('general_lifespan_experiment_intervention_result', 'general_lifespan_experiment', 'intervention_result_id', 'intervention_result_for_longevity', 'id', 'CASCADE');
        $this->addForeignKey('general_lifespan_experiment_model_organism', 'general_lifespan_experiment', 'model_organism_id', 'model_organism', 'id', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('general_lifespan_experiment_organism_line', 'general_lifespan_experiment', 'organism_line_id', 'organism_line', 'id', 'CASCADE');
        $this->dropForeignKey('general_lifespan_experiment_model_organism', 'general_lifespan_experiment');
        $this->dropForeignKey('general_lifespan_experiment_intervention_result', 'general_lifespan_experiment');

        $this->addColumn('lifespan_experiment', 'model_organism_id', $this->integer());
        $this->addColumn('lifespan_experiment', 'organism_line_id', $this->integer());
        $this->addColumn('lifespan_experiment', 'intervention_result_id', $this->integer());

        $this->addForeignKey('lifespan_experiment_organism_line', 'lifespan_experiment', 'organism_line_id', 'organism_line', 'id', 'CASCADE');
        $this->addForeignKey('lifespan_experiment_model_organism', 'lifespan_experiment', 'model_organism_id', 'model_organism', 'id', 'CASCADE');
        $this->addForeignKey('lifespan_experiment_intervention_result', 'lifespan_experiment', 'intervention_result_id', 'intervention_result', 'id', 'CASCADE');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220407_111557_deprecated_fields_remove_lifespan_experiment cannot be reverted.\n";

        return false;
    }
    */
}
