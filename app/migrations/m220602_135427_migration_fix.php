<?php

use yii\db\Migration;

/**
 * Class m220524_104757_add_new_sources
 */
class m220524_104757_add_new_sources extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('le_to_ortholog_to_le', 'lifespan_experiment_to_ortholog');
        $this->dropForeignKey('le_to_ortholog_to_ortholog', 'lifespan_experiment_to_ortholog');
        $this->dropTable('lifespan_experiment_to_ortholog');
        die;

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220524_104757_add_new_sources cannot be reverted.\n";

        return false;
    }
    */
}
