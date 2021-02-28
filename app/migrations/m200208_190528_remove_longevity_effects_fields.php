<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m200208_190528_remove_longevity_effects_fields
 */
class m200208_190528_remove_longevity_effects_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('gene_to_longevity_effect_association', 'gene_to_longevity_effect');
        $this->dropForeignKey('gene_to_longevity_effect_model_organism', 'gene_to_longevity_effect');
        $this->dropForeignKey('gene_to_longevity_effect_organism_line', 'gene_to_longevity_effect');

        $this->dropTable('gene_longevity_association_type');

        $this->dropColumn('gene_to_longevity_effect', 'gene_longevity_association_type_id');
        $this->dropColumn('gene_to_longevity_effect', 'model_organism_id');
        $this->dropColumn('gene_to_longevity_effect', 'organism_line_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('gene_longevity_association_type', [
            'id' => Schema::TYPE_PK,
            'name_ru' => Schema::TYPE_STRING,
            'name_en' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->addColumn('gene_to_longevity_effect', 'gene_longevity_association_type_id', Schema::TYPE_INTEGER);
        $this->addColumn('gene_to_longevity_effect', 'model_organism_id', Schema::TYPE_INTEGER);
        $this->addColumn('gene_to_longevity_effect', 'organism_line_id', Schema::TYPE_INTEGER);

        $this->addForeignKey('gene_to_longevity_effect_association', 'gene_to_longevity_effect', 'gene_longevity_association_type_id', 'gene_longevity_association_type', 'id');
        $this->addForeignKey('gene_to_longevity_effect_model_organism', 'gene_to_longevity_effect', 'model_organism_id', 'model_organism', 'id');
        $this->addForeignKey('gene_to_longevity_effect_organism_line', 'gene_to_longevity_effect', 'organism_line_id', 'organism_line', 'id');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200208_190528_remove_longevity_effects_fields cannot be reverted.\n";

        return false;
    }
    */
}
