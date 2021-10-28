<?php

use yii\db\Migration;

/**
 * Class m211028_114159_add_calorie_restriction_experiment
 */
class m211028_114159_add_calorie_restriction_experiment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('isoform', [
            'id' => $this->primaryKey(),
            'name_ru' => $this->string(),
            'name_en' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('measurement_type', [
            'id' => $this->primaryKey(),
            'name_ru' => $this->string(),
            'name_en' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        $this->addCommentOnTable('experiment_main_effect', 'Что измеряем');
        
        $this->createTable('measurement_method', [
            'id' => $this->primaryKey(),
            'name_ru' => $this->string(),
            'name_en' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    
        $this->createTable('calorie_restriction_experiment', [
            'id' => $this->primaryKey(),
            'gene_id' => $this->integer(),
            'p_val' => $this->float(),
            'result' => "ENUM('increase', 'decrease')",
            'measurement_method_id' => $this->integer(),
            'measurement_type_id' => $this->integer(),
            'restriction_percent' => $this->float(),
            'restriction_time' => $this->integer(),
            'restriction_time_unit_id' => $this->integer(),
            'age' => $this->float(),
            'age_time_unit_id' => $this->integer(),
            'model_organism_id' => $this->integer(),
            'strain_id' => $this->integer(),
            'organism_sex_id' => $this->integer(),
            'tissue_id' => $this->integer(),
            'isoform_id' => $this->integer(),
            'experiment_number' => $this->string(),
            'expression_change_log_fc' => $this->string(),
            'expression_change_percent' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        
        $this->addForeignKey('calorie_restr_gene_id', 'calorie_restriction_experiment', 'gene_id', 'gene', 'id');
        $this->addForeignKey('calorie_restr_measurement_method', 'calorie_restriction_experiment', 'measurement_method_id', 'measurement_method', 'id');
        $this->addForeignKey('calorie_restr_measurement_type', 'calorie_restriction_experiment', 'measurement_type_id', 'measurement_type', 'id');
        $this->addForeignKey('calorie_restr_restriction_time_unit', 'calorie_restriction_experiment', 'restriction_time_unit_id', 'treatment_time_unit', 'id'); 
        $this->addForeignKey('calorie_restr_age_time_unit', 'calorie_restriction_experiment', 'age_time_unit_id', 'treatment_time_unit', 'id');
        $this->addForeignKey('calorie_restr_model_organism_id', 'calorie_restriction_experiment', 'model_organism_id', 'model_organism', 'id');
        $this->addForeignKey('calorie_restr_strain_id', 'calorie_restriction_experiment', 'strain_id', 'organism_line', 'id');
        $this->addForeignKey('calorie_restr_organism_sex', 'calorie_restriction_experiment', 'organism_sex_id', 'organism_sex', 'id');
        $this->addForeignKey('calorie_restr_tissue', 'calorie_restriction_experiment', 'tissue_id', 'sample', 'id');
        $this->addForeignKey('calorie_restr_isoform', 'calorie_restriction_experiment', 'isoform_id', 'isoform', 'id');

        $this->batchInsert('measurement_type', ['id', 'name_en', 'name_ru'], [
            [1, 'mRNA', 'мРНК'],
            [2, 'protein', 'белок'],
            [3, 'number of cells expressing the gene', 'количество клеток, экспрессирующих ген'],
            [4, 'acetylated protein', 'ацетилированный белок'],
        ]);
        
        $this->batchInsert('measurement_method', ['id', 'name_en', 'name_ru'], [
            [1, 'RNAseq', 'секвенирование мРНК'],
            [2, 'chromatography, mass_spectrometry', 'хроматография, масс-спектрометрия'],
            [3, 'mass_spectrometry', 'масс-спектрометрия'],
            [4, 'microarray and qRT-PCR', 'микрочип и ОТ-ПЦР'],
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('calorie_restr_gene_id', 'calorie_restriction_experiment');
        $this->dropForeignKey('calorie_restr_measurement_method', 'calorie_restriction_experiment');
        $this->dropForeignKey('calorie_restr_measurement_type', 'calorie_restriction_experiment');
        $this->dropForeignKey('calorie_restr_restriction_time_unit', 'calorie_restriction_experiment');
        $this->dropForeignKey('calorie_restr_age_time_unit', 'calorie_restriction_experiment');
        $this->dropForeignKey('calorie_restr_model_organism_id', 'calorie_restriction_experiment');
        $this->dropForeignKey('calorie_restr_strain_id', 'calorie_restriction_experiment');
        $this->dropForeignKey('calorie_restr_organism_sex', 'calorie_restriction_experiment');
        $this->dropForeignKey('calorie_restr_tissue', 'calorie_restriction_experiment');
        $this->dropForeignKey('calorie_restr_isoform', 'calorie_restriction_experiment'); 

        $this->dropTable('calorie_restriction_experiment'); 
        $this->dropTable('isoform');
        $this->dropTable('measurement_type');
        $this->dropTable('measurement_method');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211028_114159_add_calory_restriction_experiment cannot be reverted.\n";

        return false;
    }
    */
}
