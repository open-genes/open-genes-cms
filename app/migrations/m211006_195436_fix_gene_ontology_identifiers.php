<?php

use yii\db\Migration;

/**
 * Class m211006_195436_fix_gene_ontology_identifiers
 */
class m211006_195436_fix_gene_ontology_identifiers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('gene_ontology', 'ontology_identifier', $this->string());
        $this->execute('update gene_ontology set ontology_identifier = concat("GO:", LPAD(ontology_identifier, 7, 0))');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('update gene_ontology set ontology_identifier = CONVERT(SUBSTRING_INDEX(ontology_identifier,":",-1),UNSIGNED INTEGER)');
        $this->alterColumn('gene_ontology', 'ontology_identifier', $this->integer());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211006_195436_fix_gene_ontology_identifiers cannot be reverted.\n";

        return false;
    }
    */
}
