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
        $this->createTable('ortholog', [
            'id' => Schema::TYPE_PK,
            'symbol' => Schema::TYPE_STRING,
            'model_organism_id' => Schema::TYPE_INTEGER,
        ]);

        $this->createTable('gene_to_ortholog', [
            'id' => Schema::TYPE_PK,
            'gene_id' => Schema::TYPE_INTEGER,
            'ortholog_id' => Schema::TYPE_INTEGER,
        ]);

        $this->addForeignKey('ortholog_to_organism', 'ortholog', 'model_organism_id', 'model_organism', 'id', 'CASCADE');
        $this->addForeignKey('gene_to_ortholog_to_gene', 'gene_to_ortholog', 'gene_id', 'gene', 'id', 'CASCADE');
        $this->addForeignKey('gene_to_ortholog_to_ortholog', 'gene_to_ortholog', 'ortholog_id', 'ortholog', 'id', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('ortholog_to_organism', 'ortholog');
        $this->dropForeignKey('gene_to_ortholog_to_gene', 'gene_to_ortholog');
        $this->dropForeignKey('gene_to_ortholog_to_ortholog', 'gene_to_ortholog');

        $this->dropTable('ortholog');
        $this->dropTable('gene_to_ortholog');
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
