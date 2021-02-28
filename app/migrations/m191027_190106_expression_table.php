<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m191027_190106_expression_table
 */
class m191027_190106_expression_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('gene', 'ID', 'id');

        $this->createTable('sample', [
            'id' => Schema::TYPE_PK,
            'name_en' => Schema::TYPE_STRING,
            'name_ru' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ]);

        $this->createTable('gene_expression_in_sample', [
            'id' => Schema::TYPE_PK,
            'gene_id' => Schema::TYPE_INTEGER,
            'sample_id' => Schema::TYPE_INTEGER,
            'expression_value' => Schema::TYPE_FLOAT,
            'expression_change' => Schema::TYPE_STRING,
        ]);

        $this->addForeignKey('gene_expression_gene', 'gene_expression_in_sample', 'gene_id', 'gene', 'id');
        $this->addForeignKey('gene_expression_sample', 'gene_expression_in_sample', 'sample_id', 'sample', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('gene_expression_gene', 'gene_expression_in_sample');
        $this->dropForeignKey('gene_expression_sample', 'gene_expression_in_sample');
        $this->dropTable('sample');
        $this->renameColumn('gene', 'id', 'ID');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191027_190106_expression_table cannot be reverted.\n";

        return false;
    }
    */
}
