<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m200131_170032_progeria_association
 */
class m200131_170032_progeria_association extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('progeria_syndrome', [
            'id' => Schema::TYPE_PK,
            'name_ru' => Schema::TYPE_STRING,
            'name_en' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('gene_to_progeria', [
            'id' => Schema::TYPE_PK,
            'gene_id' => Schema::TYPE_INTEGER,
            'progeria_syndrome_id' => Schema::TYPE_INTEGER,
            'reference' => Schema::TYPE_STRING,
            'comment_en' => Schema::TYPE_TEXT,
            'comment_ru' => Schema::TYPE_TEXT,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->addForeignKey('gene_to_progeria_gene', 'gene_to_progeria', 'gene_id', 'gene', 'id');
        $this->addForeignKey('gene_to_progeria_progeria_syndrome', 'gene_to_progeria', 'progeria_syndrome_id', 'progeria_syndrome', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('gene_to_progeria_gene', 'gene_to_progeria');
        $this->dropForeignKey('gene_to_progeria_progeria_syndrome', 'gene_to_progeria');

        $this->dropTable('gene_to_progeria');
        $this->dropTable('progeria_syndrome');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200131_170032_progeria_association cannot be reverted.\n";

        return false;
    }
    */
}
