<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m191118_171421_gene_function
 */
class m191118_171421_gene_function extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('gene', 'product', Schema::TYPE_STRING);

        $this->createTable('function', [
            'id' => Schema::TYPE_PK,
            'name_en' => Schema::TYPE_STRING,
            'name_ru' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('gene_to_function_relation_type', [
            'id' => Schema::TYPE_PK,
            'name_en' => Schema::TYPE_STRING,
            'name_ru' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('gene_to_function', [
            'id' => Schema::TYPE_PK,
            'gene_id' => Schema::TYPE_INTEGER,
            'function_id' => Schema::TYPE_INTEGER,
            'gene_to_function_relation_type_id' => Schema::TYPE_INTEGER,
            'reference' => Schema::TYPE_STRING,
            'comment' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->addForeignKey('gene_to_function_gene', 'gene_to_function', 'gene_id', 'gene', 'id');
        $this->addForeignKey('gene_to_function_function', 'gene_to_function', 'function_id', 'function', 'id');
        $this->addForeignKey('gene_to_function_relation', 'gene_to_function', 'gene_to_function_relation_type_id', 'gene_to_function_relation_type', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('gene_to_function_relation', 'gene_to_function');
        $this->dropForeignKey('gene_to_function_function', 'gene_to_function');
        $this->dropForeignKey('gene_to_function_gene', 'gene_to_function');
        $this->dropTable('gene_to_function');
        $this->dropTable('gene_to_function_relation_type');
        $this->dropTable('function');
        $this->dropColumn('gene', 'product');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191118_171421_gene_function cannot be reverted.\n";

        return false;
    }
    */
}
