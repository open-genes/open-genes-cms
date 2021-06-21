<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m210620_104552_additional_evidence_table
 */
class m210620_104552_additional_evidence_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('gene_to_additional_evidence', [
            'id' => Schema::TYPE_PK,
            'gene_id' => Schema::TYPE_INTEGER,
            'reference' => Schema::TYPE_STRING,
            'comment_ru' => Schema::TYPE_TEXT,
            'comment_en' => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->addForeignKey('gene_to_additional_evidence_gene', 'gene_to_additional_evidence', 'gene_id', 'gene', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('gene_to_additional_evidence_gene', 'gene_to_additional_evidence');
        $this->dropTable('gene_to_additional_evidence');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210620_104552_additional_evidence_table cannot be reverted.\n";

        return false;
    }
    */
}
