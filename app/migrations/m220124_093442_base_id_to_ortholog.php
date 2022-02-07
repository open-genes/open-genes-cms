<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m220124_093442_base_id_to_ortholog
 */
class m220124_093442_base_id_to_ortholog extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('ortholog', 'external_base_name', Schema::TYPE_STRING);
        $this->addColumn('ortholog', 'external_base_id', Schema::TYPE_STRING);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('ortholog', 'external_base_name');
        $this->dropColumn('ortholog', 'external_base_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220124_093442_base_id_to_ortholog cannot be reverted.\n";

        return false;
    }
    */
}
