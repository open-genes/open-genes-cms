<?php

use yii\db\Migration;

/**
 * Class m220218_224527_add_indexes_to_gene
 */
class m220218_224527_add_indexes_to_gene extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('in_gene_aliases', 'gene', 'aliases');
        $this->createIndex('in_gene_name', 'gene', 'name');
        $this->createIndex('in_gene_ensembl', 'gene', 'ensembl');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('in_gene_aliases', 'gene');
        $this->dropIndex('in_gene_name', 'gene');
        $this->dropIndex('in_gene_ensembl', 'gene');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220218_224527_add_indexes_to_gene cannot be reverted.\n";

        return false;
    }
    */
}
