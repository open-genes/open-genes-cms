<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m191202_184616_proteins
 */
class m191202_184616_proteins extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* drop previous version of tables */
        $this->dropForeignKey('gene_to_function_relation', 'gene_to_function');
        $this->dropForeignKey('gene_to_function_function', 'gene_to_function');
        $this->dropForeignKey('gene_to_function_gene', 'gene_to_function');
        $this->dropTable('gene_to_function');
        $this->dropTable('gene_to_function_relation_type');
        $this->dropTable('function');

        $this->addColumn('gene', 'protein_class_id', Schema::TYPE_INTEGER);

        $this->createTable('protein_class', [
            'id' => Schema::TYPE_PK,
            'name_en' => Schema::TYPE_STRING,
            'name_ru' => Schema::TYPE_STRING,
            'parent_id' => Schema::TYPE_INTEGER,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->addForeignKey('gene_protein_class', 'gene', 'protein_class_id', 'protein_class', 'id');


        $this->createTable('protein_activity', [
            'id' => Schema::TYPE_PK,
            'name_en' => Schema::TYPE_STRING,
            'name_ru' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('protein_activity_object', [
            'id' => Schema::TYPE_PK,
            'name_en' => Schema::TYPE_STRING,
            'name_ru' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('process_localization', [
            'id' => Schema::TYPE_PK,
            'name_en' => Schema::TYPE_STRING,
            'name_ru' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('gene_to_protein_activity', [
            'id' => Schema::TYPE_PK,
            'gene_id' => Schema::TYPE_INTEGER,
            'protein_activity_id' => Schema::TYPE_INTEGER,
            'protein_activity_object_id' => Schema::TYPE_INTEGER,
            'process_localization_id' => Schema::TYPE_INTEGER,
            'reference' => Schema::TYPE_STRING,
            'comment' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->addForeignKey('gene_to_protein_activity_gene', 'gene_to_protein_activity', 'gene_id', 'gene', 'id');
        $this->addForeignKey('gene_to_protein_activity_activity', 'gene_to_protein_activity', 'protein_activity_id', 'protein_activity', 'id');
        $this->addForeignKey('gene_to_protein_activity_object', 'gene_to_protein_activity', 'protein_activity_object_id', 'protein_activity_object', 'id');
        $this->addForeignKey('gene_to_protein_activity_localization', 'gene_to_protein_activity', 'process_localization_id', 'process_localization', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('gene_to_protein_activity_gene', 'gene_to_protein_activity');
        $this->dropForeignKey('gene_to_protein_activity_activity', 'gene_to_protein_activity');
        $this->dropForeignKey('gene_to_protein_activity_object', 'gene_to_protein_activity');
        $this->dropForeignKey('gene_to_protein_activity_localization', 'gene_to_protein_activity');

        $this->dropTable('gene_to_protein_activity');
        $this->dropTable('process_localization');
        $this->dropTable('protein_activity_object');
        $this->dropTable('protein_activity');

        $this->dropForeignKey('gene_protein_class', 'gene');
        $this->dropColumn('gene', 'protein_class_id');

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

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191202_184616_proteins cannot be reverted.\n";

        return false;
    }
    */
}
