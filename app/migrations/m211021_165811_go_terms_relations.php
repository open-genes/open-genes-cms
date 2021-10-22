<?php

use yii\db\Migration;

/**
 * Class m211021_165811_go_terms_relations
 */
class m211021_165811_go_terms_relations extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('gene_ontology_relation', [
            'id' => $this->primaryKey(),
            'gene_ontology_id' => $this->integer(),
            'gene_ontology_parent_id' => $this->integer(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        
        $this->createTable('gene_ontology_to_aging_mechanism_visible', [
            'id' => $this->primaryKey(),
            'gene_ontology_id' => $this->integer(),
            'aging_mechanism_id' => $this->integer(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        
        $this->createIndex('gene_ontology_to_aging_mechanism_visible_ids', 'gene_ontology_to_aging_mechanism_visible', 
            ['gene_ontology_id', 'aging_mechanism_id'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('gene_ontology_relation');
        $this->dropIndex('gene_ontology_to_aging_mechanism_visible_ids', 'gene_ontology_to_aging_mechanism_visible');
        $this->dropTable('gene_ontology_to_aging_mechanism_visible');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211021_165811_go_terms_relations cannot be reverted.\n";

        return false;
    }
    */
}
