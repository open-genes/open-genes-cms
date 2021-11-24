<?php

use yii\db\Migration;

/**
 * Class m211112_141243_replace_sex_green_form
 */
class m211112_141243_replace_sex_green_form extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('gene_intervention_to_vital_process', ['sex_of_organism' => 3], ['sex_of_organism' => 2]);
        $this->update('gene_intervention_to_vital_process', ['sex_of_organism' => 2], ['sex_of_organism' => null]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->update('gene_intervention_to_vital_process', ['sex_of_organism' => 2], ['sex_of_organism' => 3]);
        $this->update('gene_intervention_to_vital_process', ['sex_of_organism' => null], ['sex_of_organism' => 2]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211112_141243_replace_sex_green_form cannot be reverted.\n";

        return false;
    }
    */
}
