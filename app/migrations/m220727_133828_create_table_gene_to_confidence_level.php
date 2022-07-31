<?php

use yii\db\Migration;

/**
 * Class m220727_133828_create_table_gene_to_confidence_level
 */
class m220727_133828_create_table_gene_to_confidence_level extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%gene_to_confidence_level}}', [
            'id' => $this->primaryKey(),
            'gene_id' => $this->integer()->notNull(),
            'confidence_level_id' => $this->integer()->notNull()
        ]);

        // foreign keys
        $this->addForeignKey('fk_gtcl_gene_id', 'gene_to_confidence_level', 'gene_id',
            'gene', 'id', 'RESTRICT');
        $this->addForeignKey('fk_gtcl_confidence_level_id', 'gene_to_confidence_level', 'confidence_level_id',
            'confidence_level', 'id', 'RESTRICT');

        //indexes
        $this->createIndex('gene_to_confidence_level_gene_id_idx', 'gene_to_confidence_level', 'gene_id');
        $this->createIndex('gene_to_confidence_level_confidence_level_id_idx', 'gene_to_confidence_level', 'confidence_level_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%gene_to_confidence_level}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220727_133828_create_table_gene_to_confidence_level cannot be reverted.\n";

        return false;
    }
    */
}
