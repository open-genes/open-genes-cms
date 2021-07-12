<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m210701_104433_add_regulation_type
 */
class m210701_104433_add_regulation_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('gene_regulation_type', [
            'id' => Schema::TYPE_PK,
            'name_ru' => Schema::TYPE_STRING,
            'name_en' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->addColumn('protein_to_gene', 'regulation_type_id', $this->integer());

        $this->insert('gene_regulation_type',
            ['id' => '1', 'name_ru' => 'экспрессия гена', 'name_en' => 'gene expression']);
        $this->insert('gene_regulation_type',
            ['id' => '2', 'name_ru' => 'активность белка', 'name_en' => 'protein_activity']);

        $this->update('protein_to_gene', ['regulation_type_id' => 1], ['regulation_type' => 1]);
        $this->update('protein_to_gene', ['regulation_type_id' => 2], ['regulation_type' => 2]);

        $this->addForeignKey('protein_to_gene_reg_type', 'protein_to_gene', 'regulation_type_id', 'gene_regulation_type', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('protein_to_gene_reg_type', 'protein_to_gene');
        $this->dropColumn('protein_to_gene', 'regulation_type_id');
        $this->dropTable('gene_regulation_type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210701_104433_add_regulation_type cannot be reverted.\n";

        return false;
    }
    */
}
