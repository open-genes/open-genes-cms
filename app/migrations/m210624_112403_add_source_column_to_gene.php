<?php

use yii\db\Migration;

/**
 * Class m210624_112403_add_source_column_to_gene
 */
class m210624_112403_add_source_column_to_gene extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('gene', 'source', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('gene', 'source');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210624_112403_add_source_column_to_gene cannot be reverted.\n";

        return false;
    }
    */
}
