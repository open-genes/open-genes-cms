<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m211206_121807_temperature_to_purple_form
 */
class m211206_121807_temperature_to_purple_form extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('general_lifespan_experiment', 'temperature_from', Schema::TYPE_FLOAT . ' DEFAULT NULL');
        $this->addColumn('general_lifespan_experiment', 'temperature_to', Schema::TYPE_FLOAT . ' DEFAULT NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('general_lifespan_experiment', 'temperature_from');
        $this->dropColumn('general_lifespan_experiment', 'temperature_to');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211206_121807_temperature_to_purple_form cannot be reverted.\n";

        return false;
    }
    */
}
