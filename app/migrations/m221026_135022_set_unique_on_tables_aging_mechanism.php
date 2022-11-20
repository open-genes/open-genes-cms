<?php

use yii\db\Migration;

/**
 * Class m221026_135022_set_unique_on_tables_aging_mechanism
 */
class m221026_135022_set_unique_on_tables_aging_mechanism extends Migration
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

        $this->execute('ALTER TABLE aging_mechanism MODIFY COLUMN name_en varchar(255) NOT NULL;');
        $this->execute('ALTER TABLE aging_mechanism ADD CONSTRAINT uniq_name_en_aging_mechanism UNIQUE (name_en);');

        $this->execute('ALTER TABLE aging_mechanism_to_gene_ontology ADD CONSTRAINT uniq_gene_ontology_id_and_aging_mechanism_id UNIQUE (gene_ontology_id, aging_mechanism_id);');
        $this->execute('ALTER TABLE gene_to_ontology ADD CONSTRAINT uniq_gene_ontology_id_and_gene_id UNIQUE (gene_ontology_id, gene_id);');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('ALTER TABLE aging_mechanism DROP CHECK uniq_name_en_aging_mechanism;');
        $this->execute('ALTER TABLE aging_mechanism MODIFY COLUMN name_en varchar(255) NULL;');

        $this->execute('ALTER TABLE aging_mechanism_to_gene_ontology DROP CHECK uniq_gene_ontology_id_and_aging_mechanism_id;');
        $this->execute('ALTER TABLE gene_to_ontology DROP CHECK uniq_gene_ontology_id_and_gene_id;');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221026_135022_set_unique_on_tables_aging_mechanism cannot be reverted.\n";

        return false;
    }
    */
}
