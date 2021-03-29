<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m210327_095835_add_disease
 */
class m210327_095835_add_disease extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('disease', [
            'id' => Schema::TYPE_PK,
            'omim_id' => Schema::TYPE_INTEGER,
            'name_ru' => Schema::TYPE_STRING,
            'name_en' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('gene_to_disease', [
            'id' => Schema::TYPE_PK,
            'gene_id' => Schema::TYPE_INTEGER,
            'disease_id' => Schema::TYPE_INTEGER,
            'reference' => Schema::TYPE_STRING,
            'comment' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        
        $this->createIndex('disease_omim_unique', 'disease', 'omim_id', true);
        
        $this->addForeignKey('gene_to_disease_gene', 'gene_to_disease', 'gene_id', 'gene', 'id');
        $this->addForeignKey('gene_to_gene_to_disease_disease', 'gene_to_disease', 'disease_id', 'disease', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('gene_to_disease_gene', 'gene_to_disease');
        $this->dropForeignKey('gene_to_gene_to_disease_disease', 'gene_to_disease');
        $this->dropTable('gene_to_disease');
        $this->dropTable('disease');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210327_095835_add_disease cannot be reverted.\n";

        return false;
    }
    */
}
