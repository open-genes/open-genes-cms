<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m191107_200527_gene_timestamp
 */
class m191107_200527_gene_timestamp extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('gene', 'created_at', Schema::TYPE_INTEGER);
        $this->addColumn('gene', 'updated_at', Schema::TYPE_INTEGER);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('gene', 'created_at');
        $this->dropColumn('gene', 'updated_at');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191107_200527_gene_timestamp cannot be reverted.\n";

        return false;
    }
    */
}
