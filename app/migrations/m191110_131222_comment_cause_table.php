<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m191110_131222_comment_cause_table
 */
class m191110_131222_comment_cause_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('comment_cause', [
            'id' => Schema::TYPE_PK,
            'name_en' => Schema::TYPE_STRING,
            'name_ru' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('gene_to_comment_cause', [
            'id' => Schema::TYPE_PK,
            'gene_id' => Schema::TYPE_INTEGER,
            'comment_cause_id' => Schema::TYPE_INTEGER
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->addForeignKey('gene_to_comment_cause_gene', 'gene_to_comment_cause', 'gene_id', 'gene', 'id');
        $this->addForeignKey('gene_to_comment_cause_comment_cause', 'gene_to_comment_cause', 'comment_cause_id', 'comment_cause', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('gene_to_comment_cause_gene', 'gene_to_comment_cause');
        $this->dropForeignKey('gene_to_comment_cause_comment_cause', 'gene_to_comment_cause');
        $this->dropTable('gene_to_comment_cause');
        $this->dropTable('comment_cause');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191110_131222_comment_cause_table cannot be reverted.\n";

        return false;
    }
    */
}
