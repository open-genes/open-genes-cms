<?php

use yii\db\Migration;

/**
 * Class m220314_101714_chromosome_to_gene
 */
class m220314_101714_chromosome_to_gene extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220314_101714_chromosome_to_gene cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220314_101714_chromosome_to_gene cannot be reverted.\n";

        return false;
    }
    */
}
