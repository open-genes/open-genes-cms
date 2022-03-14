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
        $this->addColumn('gene', 'chromosome', \yii\db\Schema::TYPE_INTEGER);
        $this->createIndex('in_gene_chromosome', 'gene', 'chromosome');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('in_gene_chromosome', 'gene');
        $this->dropColumn('gene', 'chromosome');
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
