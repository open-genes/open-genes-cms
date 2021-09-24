<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m210923_073624_delete_form_gene_function
 */
class m210923_073624_delete_form_gene_function extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('gene_to_protein_activity_gene', 'gene_to_protein_activity');
        $this->dropForeignKey('gene_to_protein_activity_activity', 'gene_to_protein_activity');
        $this->dropForeignKey('gene_to_protein_activity_object', 'gene_to_protein_activity');
        $this->dropForeignKey('gene_to_protein_activity_localization', 'gene_to_protein_activity');

        $this->dropTable('protein_activity_object');
        $this->dropTable('process_localization');
        $this->dropTable('gene_to_protein_activity');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('protein_activity_object', [
            'id' => Schema::TYPE_PK,
            'name_en' => Schema::TYPE_STRING,
            'name_ru' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('process_localization', [
            'id' => Schema::TYPE_PK,
            'name_en' => Schema::TYPE_STRING,
            'name_ru' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('gene_to_protein_activity', [
            'id' => Schema::TYPE_PK,
            'gene_id' => Schema::TYPE_INTEGER,
            'protein_activity_id' => Schema::TYPE_INTEGER,
            'protein_activity_object_id' => Schema::TYPE_INTEGER,
            'process_localization_id' => Schema::TYPE_INTEGER,
            'reference' => Schema::TYPE_STRING,
            'comment' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->addForeignKey('gene_to_protein_activity_gene', 'gene_to_protein_activity', 'gene_id', 'gene', 'id');
        $this->addForeignKey('gene_to_protein_activity_activity', 'gene_to_protein_activity', 'protein_activity_id', 'protein_activity', 'id');
        $this->addForeignKey('gene_to_protein_activity_object', 'gene_to_protein_activity', 'protein_activity_object_id', 'protein_activity_object', 'id');
        $this->addForeignKey('gene_to_protein_activity_localization', 'gene_to_protein_activity', 'process_localization_id', 'process_localization', 'id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210923_073624_delete_form_gene_function cannot be reverted.\n";

        return false;
    }
    */
}
