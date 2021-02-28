<?php

use yii\db\Migration;

/**
 * Class m200419_124954_gene_unique_symbol
 */
class m200419_124954_gene_unique_symbol extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('gene', 'entrezGene', 'ncbi_id');
        $this->createIndex('gene_symbol', 'gene', 'symbol');
        $this->createIndex('gene_ncbi_id', 'gene', 'ncbi_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('gene_symbol', 'gene');
        $this->dropIndex('gene_ncbi_id', 'gene');
        $this->renameColumn('gene', 'ncbi_id', 'entrezGene');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200419_124954_gene_unique_symbol cannot be reverted.\n";

        return false;
    }
    */
}
