<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m200119_195808_age_related_changes
 */
class m200119_195808_age_related_changes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('age_related_change_type', [
            'id' => Schema::TYPE_PK,
            'name_ru' => Schema::TYPE_STRING,
            'name_en' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('age_related_change', [
            'id' => Schema::TYPE_PK,
            'gene_id' => Schema::TYPE_INTEGER,
            'age_related_change_type_id' => Schema::TYPE_INTEGER,
            'sample_id' => Schema::TYPE_INTEGER,
            'model_organism_id' => Schema::TYPE_INTEGER,
            'organism_line_id' => Schema::TYPE_INTEGER,
            'age_from' => Schema::TYPE_INTEGER,
            'age_to' => Schema::TYPE_INTEGER,
            'change_value' => Schema::TYPE_INTEGER,
            'sex_of_organism' => Schema::TYPE_TINYINT,
            'reference' => Schema::TYPE_STRING,
            'comment_en' => Schema::TYPE_TEXT,
            'comment_ru' => Schema::TYPE_TEXT,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->addForeignKey('age_related_change_gene', 'age_related_change', 'gene_id', 'gene', 'id');
        $this->addForeignKey('age_related_change_type', 'age_related_change', 'age_related_change_type_id', 'age_related_change_type', 'id');
        $this->addForeignKey('age_related_change_sample', 'age_related_change', 'sample_id', 'sample', 'id');
        $this->addForeignKey('age_related_change_model_organism', 'age_related_change', 'model_organism_id', 'model_organism', 'id');
        $this->addForeignKey('age_related_change_organism_line', 'age_related_change', 'organism_line_id', 'organism_line', 'id');

        $this->insert('age_related_change_type', [
            'name_en' => 'gene expression reduced',
            'name_ru' => 'экспрессия гена снижена',
        ]);
        $this->insert('age_related_change_type', [
            'name_en' => 'gene expression increased',
            'name_ru' => 'экспрессия гена повышена',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('age_related_change_gene', 'age_related_change');
        $this->dropForeignKey('age_related_change_type', 'age_related_change');
        $this->dropForeignKey('age_related_change_sample', 'age_related_change');
        $this->dropForeignKey('age_related_change_model_organism', 'age_related_change');
        $this->dropForeignKey('age_related_change_organism_line', 'age_related_change');

        $this->dropTable('age_related_change');
        $this->dropTable('age_related_change_type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200119_195808_age_related_changes cannot be reverted.\n";

        return false;
    }
    */
}
