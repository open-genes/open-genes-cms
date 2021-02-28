<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m191209_205455_protein_comment_and_classes
 */
class m191209_205455_protein_comment_and_classes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('gene_protein_class', 'gene');
        $this->dropColumn('gene', 'protein_class_id');

        $this->createTable('gene_to_protein_class', [
            'id' => Schema::TYPE_PK,
            'gene_id' => Schema::TYPE_INTEGER,
            'protein_class_id' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->addForeignKey('gene_to_protein_class_gene', 'gene_to_protein_class', 'gene_id', 'gene', 'id');
        $this->addForeignKey('gene_to_protein_class_protein_class', 'gene_to_protein_class', 'protein_class_id', 'protein_class', 'id');

        $this->addColumn('gene_to_protein_activity', 'comment_en', Schema::TYPE_TEXT);
        $this->addColumn('gene_to_protein_activity', 'comment_ru', Schema::TYPE_TEXT);
        $this->dropColumn('gene_to_protein_activity', 'comment');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('gene_to_protein_activity', 'comment', Schema::TYPE_TEXT);
        $this->dropForeignKey('gene_to_protein_class_protein_class', 'gene_to_protein_class');
        $this->dropForeignKey('gene_to_protein_class_gene', 'gene_to_protein_class');
        $this->addColumn('gene', 'protein_class_id', Schema::TYPE_INTEGER);
        $this->dropTable('gene_to_protein_class');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191209_205455_protein_comment_en cannot be reverted.\n";

        return false;
    }
    */
}
