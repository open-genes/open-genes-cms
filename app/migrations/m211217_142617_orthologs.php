<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m211217_142617_orthologs
 */
class m211217_142617_orthologs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('orthologs', [
            'id' => Schema::TYPE_PK,
            'symbol' => Schema::TYPE_STRING,
            'model_organism_id' => Schema::TYPE_INTEGER,
        ]);

        $this->createTable('gene_to_orthologs', [
            'id' => Schema::TYPE_PK,
            'gene_id' => Schema::TYPE_INTEGER,
            'ortholog_id' => Schema::TYPE_INTEGER,
        ]);

        $this->addForeignKey('ortholog_to_organism', 'orthologs', 'model_organism_id', 'model_organism', 'id');
        $this->addForeignKey('gene_to_orthologs_to_gene', 'gene_to_orthologs', 'gene_id', 'gene', 'id');
        $this->addForeignKey('gene_to_orthologs_to_ortholog', 'gene_to_orthologs', 'ortholog_id', 'orthologs', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('ortholog_to_organism', 'orthologs');
        $this->dropForeignKey('gene_to_orthologs_to_gene', 'gene_to_orthologs');
        $this->dropForeignKey('gene_to_orthologs_to_ortholog', 'gene_to_orthologs');

        $this->dropTable('orthologs');
        $this->dropTable('gene_to_orthologs');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211217_142617_orthologs cannot be reverted.\n";

        return false;
    }
    */
}
