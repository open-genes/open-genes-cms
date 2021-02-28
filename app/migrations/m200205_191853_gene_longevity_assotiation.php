<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m200205_191853_gene_longevity_assotiation
 */
class m200205_191853_gene_longevity_assotiation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('longevity_effect', [
            'id' => Schema::TYPE_PK,
            'name_ru' => Schema::TYPE_STRING,
            'name_en' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('gene_longevity_association_type', [
            'id' => Schema::TYPE_PK,
            'name_ru' => Schema::TYPE_STRING,
            'name_en' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('genotype', [
            'id' => Schema::TYPE_PK,
            'name_ru' => Schema::TYPE_STRING,
            'name_en' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('gene_to_longevity_effect', [
            'id' => Schema::TYPE_PK,
            'gene_id' => Schema::TYPE_INTEGER,
            'longevity_effect_id' => Schema::TYPE_INTEGER,
            'gene_longevity_association_type_id' => Schema::TYPE_INTEGER,
            'model_organism_id' => Schema::TYPE_INTEGER,
            'organism_line_id' => Schema::TYPE_INTEGER,
            'genotype_id' => Schema::TYPE_INTEGER,
            'sex_of_organism' => Schema::TYPE_INTEGER,
            'reference' => Schema::TYPE_STRING,
            'comment_en' => Schema::TYPE_TEXT,
            'comment_ru' => Schema::TYPE_TEXT,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->addForeignKey('gene_to_longevity_effect_gene', 'gene_to_longevity_effect', 'gene_id', 'gene', 'id');
        $this->addForeignKey('gene_to_longevity_effect_genotype', 'gene_to_longevity_effect', 'genotype_id', 'genotype', 'id');
        $this->addForeignKey('gene_to_longevity_effect_longevity_effect', 'gene_to_longevity_effect', 'longevity_effect_id', 'longevity_effect', 'id');
        $this->addForeignKey('gene_to_longevity_effect_association', 'gene_to_longevity_effect', 'gene_longevity_association_type_id', 'gene_longevity_association_type', 'id');
        $this->addForeignKey('gene_to_longevity_effect_model_organism', 'gene_to_longevity_effect', 'model_organism_id', 'model_organism', 'id');
        $this->addForeignKey('gene_to_longevity_effect_organism_line', 'gene_to_longevity_effect', 'organism_line_id', 'organism_line', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('gene_to_longevity_effect_gene', 'gene_to_longevity_effect');
        $this->dropForeignKey('gene_to_longevity_effect_longevity_effect', 'gene_to_longevity_effect');
        $this->dropForeignKey('gene_to_longevity_effect_genotype', 'gene_to_longevity_effect');
        $this->dropForeignKey('gene_to_longevity_effect_association', 'gene_to_longevity_effect');
        $this->dropForeignKey('gene_to_longevity_effect_model_organism', 'gene_to_longevity_effect');
        $this->dropForeignKey('gene_to_longevity_effect_organism_line', 'gene_to_longevity_effect');

        $this->dropTable('gene_to_longevity_effect');
        $this->dropTable('gene_longevity_association_type');
        $this->dropTable('genotype');
        $this->dropTable('longevity_effect');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200205_191853_gene_longevity_assotiation cannot be reverted.\n";

        return false;
    }
    */
}
