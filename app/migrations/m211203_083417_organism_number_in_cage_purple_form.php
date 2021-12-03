<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m211203_083417_organism_number_in_cage_purple_form
 */
class m211203_083417_organism_number_in_cage_purple_form extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('general_lifespan_experiment', 'organism_number_in_cage', Schema::TYPE_INTEGER . ' DEFAULT NULL AFTER `experiment_number`');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('general_lifespan_experiment', 'organism_number_in_cage');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211203_083417_organism_number_in_cage_purple_form cannot be reverted.\n";

        return false;
    }
    */
}
