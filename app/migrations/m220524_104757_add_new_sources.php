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
        $this->insert('source', ['name' => 'human-change-expression']);
        $this->insert('source', ['name' => 'human-change-serum']);
        $this->insert('source', ['name' => 'longevity-association']);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('source', ['name' => 'human-change-expression']);
        $this->delete('source', ['name' => 'human-change-serum']);
        $this->delete('source', ['name' => 'longevity-association']);
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
