<?php

use yii\db\Migration;

/**
 * Class m220428_141923_pink_form
 */
class m220428_141923_pink_form extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('gene_to_longevity_effect', 'model_organism_id');

        $this->addColumn('gene_to_longevity_effect', 'nucleotide_change', $this->text());
        $this->addColumn('gene_to_longevity_effect', 'amino_acid_change', $this->text());
        $this->addColumn('gene_to_longevity_effect', 'polymorphism_other', $this->text());

        $this->addColumn('gene_to_longevity_effect', 'position_id', $this->integer());
        $this->createTable('position', [
            'id' => $this->primaryKey(),
            'name_en' => $this->string(),
            'name_ru' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        $this->batchInsert(
            'position',
            ['id', 'name_ru', 'name_en'],
            [
                [1, 'итрон', 'intron'],
                [2, 'экзон', 'exon'],
                [3, 'промотер', 'promoter'],
                [4, "3'UTR", "3'UTR"],
                [5, "5'", "5'"],
            ]
        );
        $this->addForeignKey('gene_to_longevity_effect_to_position', 'gene_to_longevity_effect', 'position_id', 'position', 'id', 'CASCADE');

        $this->addColumn('gene_to_longevity_effect', 'polymorphism_type_id', $this->integer());
        $this->createTable('polymorphism_type', [
            'id' => $this->primaryKey(),
            'name_en' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        $this->batchInsert(
            'polymorphism_type',
            ['id', 'name_en'],
            [
                [1, 'SNP'],
                [2, 'VNTR'],
                [3, 'In/Del'],
                [4, 'haplotype'],
            ]
        );
        $this->addForeignKey('gene_to_longevity_effect_to_polymorphism_type', 'gene_to_longevity_effect', 'polymorphism_type_id', 'polymorphism_type', 'id', 'CASCADE');

        $this->addColumn('gene_to_longevity_effect', 'non_associated_allele', $this->text());
        $this->addColumn('gene_to_longevity_effect', 'frequency_controls', $this->float());
        $this->addColumn('gene_to_longevity_effect', 'frequency_experiment', $this->float());
        $this->addColumn('gene_to_longevity_effect', 'significance', $this->integer());
        $this->addColumn('gene_to_longevity_effect', 'n_of_controls', $this->integer());
        $this->addColumn('gene_to_longevity_effect', 'n_of_experiment', $this->integer());
        $this->addColumn('gene_to_longevity_effect', 'min_age_of_controls', $this->float());
        $this->addColumn('gene_to_longevity_effect', 'max_age_of_controls', $this->float());
        $this->addColumn('gene_to_longevity_effect', 'mean_age_of_controls', $this->float());
        $this->addColumn('gene_to_longevity_effect', 'min_age_of_experiment', $this->float());
        $this->addColumn('gene_to_longevity_effect', 'max_age_of_experiment', $this->float());
        $this->addColumn('gene_to_longevity_effect', 'mean_age_of_experiment', $this->float());

        $this->addColumn('gene_to_longevity_effect', 'ethnicity_id', $this->integer());//доделать
        $this->createTable('ethnicity', [
            'id' => $this->primaryKey(),
            'name_ru' => $this->string(),
            'name_en' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        $this->batchInsert(
            'ethnicity',
            ['id', 'name_ru', 'name_en'],
            [
                [1, 'японская', 'Japanese'],
                [2, 'итальянская', 'Italian'],
                [3, 'китайская', 'Chinese'],
                [4, 'немецкая', 'German'],
            ]
        );
        $this->addForeignKey('gene_to_longevity_effect_to_ethnicity', 'gene_to_longevity_effect', 'ethnicity_id', 'ethnicity', 'id', 'CASCADE');

        $this->addColumn('gene_to_longevity_effect', 'study_type_id', $this->integer());
        $this->createTable('study_type', [
            'id' => $this->primaryKey(),
            'name_ru' => $this->string(),
            'name_en' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        $this->batchInsert(
            'study_type',
            ['id', 'name_ru', 'name_en'],
            [
                [1, 'исследование генов-кандидатов', 'candidate genes study'],
                [2, 'GWAS', 'GWAS'],
                [3, 'метаанализ исследований генов кандидатов', 'meta-analysis of candidate genes studies'],
                [4, 'метаанализ GWAS', 'meta-analysis of GWAS'],
            ]
        );
        $this->addForeignKey('gene_to_longevity_effect_to_study_type', 'gene_to_longevity_effect', 'study_type_id', 'study_type', 'id', 'CASCADE');

        $this->execute('update gene_to_longevity_effect
                                set sex_of_organism = 3
                                where sex_of_organism = 2');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('gene_to_longevity_effect_to_study_type', 'gene_to_longevity_effect');
        $this->dropTable('study_type');
        $this->dropColumn('gene_to_longevity_effect', 'study_type_id');

        $this->dropForeignKey('gene_to_longevity_effect_to_ethnicity', 'gene_to_longevity_effect');
        $this->dropTable('ethnicity');
        $this->dropColumn('gene_to_longevity_effect', 'ethnicity_id');

        $this->dropColumn('gene_to_longevity_effect', 'non_associated_allele');
        $this->dropColumn('gene_to_longevity_effect', 'frequency_controls');
        $this->dropColumn('gene_to_longevity_effect', 'frequency_experiment');
        $this->dropColumn('gene_to_longevity_effect', 'significance');
        $this->dropColumn('gene_to_longevity_effect', 'n_of_controls');
        $this->dropColumn('gene_to_longevity_effect', 'n_of_experiment');
        $this->dropColumn('gene_to_longevity_effect', 'min_age_of_controls');
        $this->dropColumn('gene_to_longevity_effect', 'max_age_of_controls');
        $this->dropColumn('gene_to_longevity_effect', 'mean_age_of_controls');
        $this->dropColumn('gene_to_longevity_effect', 'min_age_of_experiment');
        $this->dropColumn('gene_to_longevity_effect', 'max_age_of_experiment');
        $this->dropColumn('gene_to_longevity_effect', 'mean_age_of_experiment');

        $this->dropForeignKey('gene_to_longevity_effect_to_polymorphism_type', 'gene_to_longevity_effect');
        $this->dropTable('polymorphism_type');
        $this->dropColumn('gene_to_longevity_effect', 'polymorphism_type_id');

        $this->dropForeignKey('gene_to_longevity_effect_to_position', 'gene_to_longevity_effect');
        $this->dropTable('position');
        $this->dropColumn('gene_to_longevity_effect', 'position_id');

        $this->dropColumn('gene_to_longevity_effect', 'nucleotide_change');
        $this->dropColumn('gene_to_longevity_effect', 'amino_acid_change');
        $this->dropColumn('gene_to_longevity_effect', 'polymorphism_other');

        $this->addColumn('gene_to_longevity_effect', 'model_organism_id', $this->integer());

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220418_091315_pink_form_new_fields cannot be reverted.\n";

        return false;
    }
    */
}
