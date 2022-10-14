<?php

use yii\db\Migration;

/**
 * Class m220809_043341_create_table_data_types
 */
class m220809_043341_create_table_data_types extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        echo 'SKIP';
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220809_043341_create_table_data_types cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220809_043341_create_table_data_types cannot be reverted.\n";

        return false;
    }
    */
}
