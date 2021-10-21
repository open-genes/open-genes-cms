<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m211005_171659_add_aging_mechanism
 */
class m211005_171659_add_aging_mechanism extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('aging_mechanism', [
            'id' => Schema::TYPE_PK,
            'name_ru' => Schema::TYPE_STRING,
            'name_en' => Schema::TYPE_STRING,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('aging_mechanism_to_gene_ontology', [
            'id' => Schema::TYPE_PK,
            'gene_ontology_id' => Schema::TYPE_INTEGER,
            'aging_mechanism_id' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        
        $this->addForeignKey(
            'aging_mechanism_to_gene_ontology_gene_ontology',
            'aging_mechanism_to_gene_ontology',
            'gene_ontology_id',
            'gene_ontology',
            'id'
        );
        $this->addForeignKey(
            'aging_mechanism_to_gene_ontology_aging_mechanism',
            'aging_mechanism_to_gene_ontology',
            'aging_mechanism_id',
            'aging_mechanism',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'aging_mechanism_to_gene_ontology_aging_mechanism',
            'aging_mechanism_to_gene_ontology'
        );
        $this->dropForeignKey(
            'aging_mechanism_to_gene_ontology_gene_ontology',
            'aging_mechanism_to_gene_ontology'
        );
        $this->dropTable('aging_mechanism_to_gene_ontology');
        $this->dropTable('aging_mechanism');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211005_171659_add_aging_mechanism cannot be reverted.\n";

        return false;
    }
    */
}
