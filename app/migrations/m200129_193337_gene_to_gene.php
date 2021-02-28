<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m200129_193337_gene_to_gene
 */
class m200129_193337_gene_to_gene extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('protein_to_gene', [
            'id' => Schema::TYPE_PK,
            'gene_id' => Schema::TYPE_INTEGER,
            'regulated_gene_id' => Schema::TYPE_INTEGER,
            'protein_activity_id' => Schema::TYPE_INTEGER,
            'reference' => Schema::TYPE_STRING,
            'comment_en' => Schema::TYPE_TEXT,
            'comment_ru' => Schema::TYPE_TEXT,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->addForeignKey('protein_to_gene_gene', 'protein_to_gene', 'gene_id', 'gene', 'id');
        $this->addForeignKey('protein_to_gene_regulated_gene', 'protein_to_gene', 'regulated_gene_id', 'gene', 'id');
        $this->addForeignKey('protein_to_gene_protein_activity', 'protein_to_gene', 'protein_activity_id', 'protein_activity', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('protein_to_gene_gene', 'protein_to_gene');
        $this->dropForeignKey('protein_to_gene_regulated_gene', 'protein_to_gene');
        $this->dropForeignKey('protein_to_gene_protein_activity', 'protein_to_gene');
        $this->dropTable('protein_to_gene');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200129_193337_gene_to_gene cannot be reverted.\n";

        return false;
    }
    */
}
