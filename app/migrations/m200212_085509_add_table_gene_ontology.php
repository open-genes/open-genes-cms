<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m200212_085509_add_table_gene_ontology
 */
class m200212_085509_add_table_gene_ontology extends Migration
{
    public function safeUp()
    {
        $this->createTable('gene_ontology', [
            'id' => Schema::TYPE_PK,
            'ontology_identifier' => Schema::TYPE_INTEGER,
            'category' => Schema::TYPE_STRING,
            'name_en' => Schema::TYPE_STRING,
            'name_ru' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ]);

        $this->createTable('gene_to_ontology', [
            'id' => Schema::TYPE_PK,
            'gene_id' => Schema::TYPE_INTEGER,
            'gene_ontology_id' => Schema::TYPE_INTEGER,
        ]);

        $this->addForeignKey('gene_to_ontology_gene', 'gene_to_ontology', 'gene_id', 'gene', 'id');
        $this->addForeignKey('gene_to_ontology_gene_ontology', 'gene_to_ontology', 'gene_ontology_id', 'gene_ontology', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('gene_to_ontology_gene_ontology', 'gene_expression_in_sample');
        $this->dropForeignKey('gene_to_ontology_gene', 'gene_expression_in_sample');
        $this->dropTable('gene_to_ontology');
        $this->dropTable('gene_ontology');
    }
}
