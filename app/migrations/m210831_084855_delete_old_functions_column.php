<?php

use yii\db\Migration;

/**
 * Class m210831_084855_delete_old_functions_column
 */
class m210831_084855_delete_old_functions_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('gene', 'commentFunction');
        $this->dropColumn('gene', 'commentFunctionEN');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('gene', 'commentFunction', $this->text());
        $this->addColumn('gene', 'commentFunctionEN', $this->text());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210831_084855_delete_old_functions_column cannot be reverted.\n";

        return false;
    }
    */
}
