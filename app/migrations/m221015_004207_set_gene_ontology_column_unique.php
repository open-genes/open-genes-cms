<?php

use yii\db\Migration;

/**
 * Class m221015_004207_set_gene_ontology_column_unique
 */
class m221015_004207_set_gene_ontology_column_unique extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('DELETE FROM gene_ontology_to_aging_mechanism_visible');
        $this->execute('DELETE FROM aging_mechanism_to_gene_ontology');
        $this->execute('DELETE FROM gene_to_ontology');
        $this->execute('DELETE FROM gene_ontology_relation');
        $this->execute('DELETE FROM aging_mechanism');
        $this->execute('DELETE FROM gene_ontology');


        $this->execute('ALTER TABLE gene_ontology MODIFY COLUMN ontology_identifier varchar(255) NOT NULL;');
        $this->execute('ALTER TABLE gene_ontology ADD CONSTRAINT uniq_ontology_identifier UNIQUE (ontology_identifier);');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('ALTER TABLE gene_ontology DROP CHECK uniq_ontology_identifier;');
        $this->execute('ALTER TABLE gene_ontology MODIFY COLUMN ontology_identifier varchar(255) NULL;');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221015_004207_set_gene_ontology_column_unique cannot be reverted.\n";

        return false;
    }
    */
}
