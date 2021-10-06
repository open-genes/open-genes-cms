<?php

use yii\db\Migration;

/**
 * Class m210901_150807_extend_lifispan_experiments_form
 */
class m210901_150807_extend_lifispan_experiments_form extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('experiment_main_effect', [
            'id' => $this->primaryKey(),
            'name_ru' => $this->string(),
            'name_en' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        $this->addCommentOnTable('experiment_main_effect', 'Основной эффект');

        $this->createTable('gene_intervention_way', [
            'id' => $this->primaryKey(),
            'name_ru' => $this->string(),
            'name_en' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        $this->addCommentOnTable('gene_intervention_way', 'Способ воздействия на ген');

        $this->createTable('active_substance', [
            'id' => $this->primaryKey(),
            'name_ru' => $this->string(),
            'name_en' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        $this->addCommentOnTable('active_substance', 'Действующее вещество');

        $this->createTable('active_substance_delivery_way', [
            'id' => $this->primaryKey(),
            'name_ru' => $this->string(),
            'name_en' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        $this->addCommentOnTable('active_substance_delivery_way', 'Способ введения вещества');

        $this->createTable('active_substance_dosage_unit', [
            'id' => $this->primaryKey(),
            'name_ru' => $this->string(),
            'name_en' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        $this->addCommentOnTable('active_substance_dosage_unit', 'Размерность дозировки вещества');

        $this->createTable('experiment_treatment_period', [
            'id' => $this->primaryKey(),
            'name_ru' => $this->string(),
            'name_en' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        $this->addCommentOnTable('experiment_treatment_period', 'Размерность дозировки вещества');

        $this->createTable('treatment_stage_of_development', [
            'id' => $this->primaryKey(),
            'name_ru' => $this->string(),
            'name_en' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        $this->addCommentOnTable('treatment_stage_of_development', 'Точка отсчета воздействия');

        $this->createTable('gene_intervention_method', [ // evolutionary migration from gene_intervention table
            'id' => $this->primaryKey(),
            'name_ru' => $this->string(),
            'name_en' => $this->string(),
            'gene_intervention_way_id' => $this->integer(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        $this->addCommentOnTable('gene_intervention_method', 'Метод');

        $this->createTable('treatment_time_unit', [
            'id' => $this->primaryKey(),
            'name_ru' => $this->string(),
            'name_en' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        $this->addCommentOnTable('treatment_time_unit', 'Единица измерения времени');

        $this->createTable('lifespan_experiment_to_tissue', [
            'id' => $this->primaryKey(),
            'lifespan_experiment_id' => $this->integer(),
            'tissue_id' => $this->integer(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('general_lifespan_experiment_to_strain', [
            'id' => $this->primaryKey(),
            'general_lifespan_experiment_id' => $this->integer(),
            'strain_id' => $this->integer(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('lifespan_experiment_to_intervention_way', [
            'id' => $this->primaryKey(),
            'lifespan_experiment_id' => $this->integer(),
            'gene_intervention_way_id' => $this->integer(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('organism_sex', [
            'id' => $this->primaryKey(),
            'name_ru' => $this->string(),
            'name_en' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        $this->addCommentOnTable('treatment_time_unit', 'Пол организмов');

        $this->createTable('statistical_significance', [
            'id' => $this->primaryKey(),
            'name_ru' => $this->string(),
            'name_en' => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        $this->addCommentOnTable('statistical_significance', 'Статистическая значимость');

        $this->createTable('general_lifespan_experiment', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'control_lifespan_min' => $this->smallInteger()
                ->comment('Мин. прод-ть жизни контроля'),
            'control_lifespan_mean' => $this->smallInteger()
                ->comment('Средняя прод-ть жизни контроля'),
            'control_lifespan_median' => $this->smallInteger()
                ->comment('Медиана прод-ти жизни контроля'),
            'control_lifespan_max' => $this->smallInteger()
                ->comment('Макс. прод-ть жизни контроля'),
            'experiment_lifespan_min' => $this->smallInteger()
                ->comment('Мин. прод-ть жизни эксперимента'),
            'experiment_lifespan_mean' => $this->smallInteger()
                ->comment('Средняя прод-ть жизни эксперимента'),
            'experiment_lifespan_median' => $this->smallInteger()
                ->comment('Медиана прод-ти жизни эксперимента'),
            'experiment_lifespan_max' => $this->smallInteger()
                ->comment('Макс. прод-ть жизни эксперимента'),
            'lifespan_min_change' => $this->smallInteger()
                ->comment('Мин. прод-ть жизни % изменения'),
            'lifespan_mean_change' => $this->smallInteger()
                ->comment('Сред. прод-ть жизни % изменения'),
            'lifespan_median_change' => $this->smallInteger()
                ->comment('Медиана прод-ти жизни % изменения'),
            'lifespan_max_change' => $this->smallInteger()
                ->comment('Макс. прод-ть жизни % изменения'),
            'control_number' => $this->smallInteger()
                ->comment('Количество организмов в контроле'),
            'experiment_number' => $this->smallInteger()
                ->comment('Количество организмов в эксперименте'),
            'expression_change' => $this->smallInteger()
                ->comment('Степень изменения экспрессии гена %'),
            'changed_expression_tissue_id' => $this->integer()
                ->comment('Ткань/клетки'),
            'lifespan_change_time_unit_id' => $this->integer(),
            'age' => $this->integer(),
            'age_unit' => $this->integer(),
            'intervention_result_id' => $this->integer(),
            'lifespan_change_percent_male' => $this->integer(), // temp
            'lifespan_change_percent_female' => $this->integer(), // temp
            'lifespan_change_percent_common' => $this->integer(), // temp
            'lifespan_min_change_stat_sign_id' => $this->integer(),
            'lifespan_mean_change_stat_sign_id' => $this->integer(),
            'lifespan_median_change_stat_sign_id' => $this->integer(),
            'lifespan_max_change_stat_sign_id' => $this->integer(),
            'model_organism_id' => $this->integer(),
            'organism_line_id' => $this->integer(),
            'organism_sex_id' => $this->integer(),
            'reference' => $this->string(),
            'pmid' => $this->string(),
            'comment_en' => $this->text(),
            'comment_ru' => $this->text(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->addColumn('lifespan_experiment', 'tissue_specificity', $this->tinyInteger(1)
            ->defaultValue(0)
            ->comment('Тканеспецифичность'));
        $this->addColumn('lifespan_experiment', 'active_substance_daily_dose', $this->smallInteger()
            ->comment('Дневная доза'));
        $this->addColumn('lifespan_experiment', 'active_substance_daily_doses_number', $this->smallInteger()
            ->comment('Количество воздействий в день'));
        $this->addColumn('lifespan_experiment', 'treatment_start', $this->smallInteger()
            ->comment('Начало периода воздействия'));
        $this->addColumn('lifespan_experiment', 'treatment_end', $this->smallInteger()
            ->comment('Конец периода воздействия'));
        
        $this->addColumn('lifespan_experiment', 'active_substance_id', $this->integer());
        $this->addColumn('lifespan_experiment', 'active_substance_delivery_way_id', $this->integer());
        $this->addColumn('lifespan_experiment', 'active_substance_dosage_unit_id', $this->integer());
        $this->addColumn('lifespan_experiment', 'treatment_period_id', $this->integer());
        $this->addColumn('lifespan_experiment', 'gene_intervention_method_id', $this->integer());
        $this->addColumn('lifespan_experiment', 'experiment_main_effect_id', $this->integer());
        $this->addColumn('lifespan_experiment', 'treatment_start_stage_of_development_id', $this->integer());
        $this->addColumn('lifespan_experiment', 'treatment_end_stage_of_development_id', $this->integer());
        $this->addColumn('lifespan_experiment', 'treatment_start_time_unit_id', $this->integer());
        $this->addColumn('lifespan_experiment', 'treatment_end_time_unit_id', $this->integer());
        $this->addColumn('lifespan_experiment', 'general_lifespan_experiment_id', $this->integer());
        $this->addColumn('lifespan_experiment', 'type', "ENUM('control', 'experiment')");

        $this->addForeignKey('lifespan_experiment_active_substance', 'lifespan_experiment', 'active_substance_id', 'active_substance', 'id');
        $this->addForeignKey('lifespan_experiment_active_substance_delivery_way', 'lifespan_experiment', 'active_substance_delivery_way_id', 'active_substance_delivery_way', 'id');
        $this->addForeignKey('lifespan_experiment_active_substance_dosage_unit', 'lifespan_experiment', 'active_substance_dosage_unit_id', 'active_substance_dosage_unit', 'id');
        $this->addForeignKey('lifespan_experiment_experiment_treatment_period', 'lifespan_experiment', 'treatment_period_id', 'experiment_treatment_period', 'id');
        $this->addForeignKey('lifespan_experiment_treatment_start_stage_of_development', 'lifespan_experiment', 'treatment_start_stage_of_development_id', 'treatment_stage_of_development', 'id');
        $this->addForeignKey('lifespan_experiment_treatment_end_stage_of_development', 'lifespan_experiment', 'treatment_end_stage_of_development_id', 'treatment_stage_of_development', 'id');
        $this->addForeignKey('lifespan_experiment_gene_intervention_method', 'lifespan_experiment', 'gene_intervention_method_id', 'gene_intervention_method', 'id');
        $this->addForeignKey('lifespan_experiment_experiment_main_effect', 'lifespan_experiment', 'experiment_main_effect_id', 'experiment_main_effect', 'id');
        $this->addForeignKey('lifespan_experiment_start_time_unit', 'lifespan_experiment', 'treatment_start_time_unit_id', 'treatment_time_unit', 'id');
        $this->addForeignKey('lifespan_experiment_end_time_unit', 'lifespan_experiment', 'treatment_end_time_unit_id', 'treatment_time_unit', 'id');
        $this->addForeignKey('lifespan_experiment_common_lifespan_experiment', 'lifespan_experiment', 'general_lifespan_experiment_id', 'general_lifespan_experiment', 'id');
        
        $this->addForeignKey('lifespan_experiment_lifespan_change_time_unit', 'general_lifespan_experiment', 'lifespan_change_time_unit_id', 'treatment_time_unit', 'id');
        $this->addForeignKey('lifespan_experiment_min_change_stat_sign', 'general_lifespan_experiment', 'lifespan_min_change_stat_sign_id', 'statistical_significance', 'id');
        $this->addForeignKey('lifespan_experiment_mean_change_stat_sign', 'general_lifespan_experiment', 'lifespan_mean_change_stat_sign_id', 'statistical_significance', 'id');
        $this->addForeignKey('lifespan_experiment_median_change_stat_sign', 'general_lifespan_experiment', 'lifespan_median_change_stat_sign_id', 'statistical_significance', 'id');
        $this->addForeignKey('lifespan_experiment_organism_sex', 'general_lifespan_experiment', 'organism_sex_id', 'organism_sex', 'id');
        $this->addForeignKey('lifespan_experiment_changed_expression_tissue', 'general_lifespan_experiment', 'changed_expression_tissue_id', 'sample', 'id');
        $this->addForeignKey('lifespan_experiment_max_change_stat_sign', 'general_lifespan_experiment', 'lifespan_max_change_stat_sign_id', 'statistical_significance', 'id');

        $this->addForeignKey('lifespan_experiment_to_tissue_lsn', 'lifespan_experiment_to_tissue', 'lifespan_experiment_id', 'lifespan_experiment', 'id');
        $this->addForeignKey('lifespan_experiment_to_tissue_tss', 'lifespan_experiment_to_tissue', 'tissue_id', 'sample', 'id');

        $this->addForeignKey('general_lifespan_experiment_to_strain_lsn', 'general_lifespan_experiment_to_strain', 'general_lifespan_experiment_id', 'general_lifespan_experiment', 'id');
        $this->addForeignKey('general_lifespan_experiment_to_strain_str', 'general_lifespan_experiment_to_strain', 'strain_id', 'organism_line', 'id');

        $this->addForeignKey('lifespan_experiment_to_intervention_way_lsn', 'lifespan_experiment_to_intervention_way', 'lifespan_experiment_id', 'lifespan_experiment', 'id');
        $this->addForeignKey('lifespan_experiment_to_intervention_way_inw', 'lifespan_experiment_to_intervention_way', 'gene_intervention_way_id', 'gene_intervention_way', 'id');

        $this->addForeignKey('gene_intervention_method_way', 'gene_intervention_method', 'gene_intervention_way_id', 'gene_intervention_way', 'id');

        $this->insertData();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('gene_intervention_method_way', 'gene_intervention_method');

        $this->dropForeignKey('lifespan_experiment_active_substance', 'lifespan_experiment');
        $this->dropForeignKey('lifespan_experiment_active_substance_delivery_way', 'lifespan_experiment');
        $this->dropForeignKey('lifespan_experiment_active_substance_dosage_unit', 'lifespan_experiment');
        $this->dropForeignKey('lifespan_experiment_experiment_treatment_period', 'lifespan_experiment');
        $this->dropForeignKey('lifespan_experiment_treatment_start_stage_of_development', 'lifespan_experiment');
        $this->dropForeignKey('lifespan_experiment_treatment_end_stage_of_development', 'lifespan_experiment');
        $this->dropForeignKey('lifespan_experiment_gene_intervention_method', 'lifespan_experiment');
        $this->dropForeignKey('lifespan_experiment_experiment_main_effect', 'lifespan_experiment');
        $this->dropForeignKey('lifespan_experiment_start_time_unit', 'lifespan_experiment');
        $this->dropForeignKey('lifespan_experiment_end_time_unit', 'lifespan_experiment');
        $this->dropForeignKey('lifespan_experiment_common_lifespan_experiment', 'lifespan_experiment');
        
        $this->dropForeignKey('lifespan_experiment_lifespan_change_time_unit', 'general_lifespan_experiment');
        $this->dropForeignKey('lifespan_experiment_min_change_stat_sign', 'general_lifespan_experiment');
        $this->dropForeignKey('lifespan_experiment_mean_change_stat_sign', 'general_lifespan_experiment');
        $this->dropForeignKey('lifespan_experiment_median_change_stat_sign', 'general_lifespan_experiment');
        $this->dropForeignKey('lifespan_experiment_max_change_stat_sign', 'general_lifespan_experiment');
        $this->dropForeignKey('lifespan_experiment_organism_sex', 'general_lifespan_experiment');
        $this->dropForeignKey('lifespan_experiment_changed_expression_tissue', 'general_lifespan_experiment');

        $this->dropForeignKey('lifespan_experiment_to_tissue_lsn', 'lifespan_experiment_to_tissue');
        $this->dropForeignKey('lifespan_experiment_to_tissue_tss', 'lifespan_experiment_to_tissue');

        $this->dropForeignKey('general_lifespan_experiment_to_strain_lsn', 'general_lifespan_experiment_to_strain');
        $this->dropForeignKey('general_lifespan_experiment_to_strain_str', 'general_lifespan_experiment_to_strain');

        $this->dropForeignKey('lifespan_experiment_to_intervention_way_lsn', 'lifespan_experiment_to_intervention_way');
        $this->dropForeignKey('lifespan_experiment_to_intervention_way_inw', 'lifespan_experiment_to_intervention_way');

        $this->dropColumn('lifespan_experiment', 'active_substance_id');
        $this->dropColumn('lifespan_experiment', 'active_substance_delivery_way_id');
        $this->dropColumn('lifespan_experiment', 'active_substance_dosage_unit_id');
        $this->dropColumn('lifespan_experiment', 'treatment_period_id');
        $this->dropColumn('lifespan_experiment', 'gene_intervention_method_id');
        $this->dropColumn('lifespan_experiment', 'experiment_main_effect_id');
        $this->dropColumn('lifespan_experiment', 'treatment_start_stage_of_development_id');
        $this->dropColumn('lifespan_experiment', 'treatment_end_stage_of_development_id');
        $this->dropColumn('lifespan_experiment', 'treatment_start_time_unit_id');
        $this->dropColumn('lifespan_experiment', 'treatment_end_time_unit_id');
        $this->dropColumn('lifespan_experiment', 'general_lifespan_experiment_id');
        $this->dropColumn('lifespan_experiment', 'type');

        $this->dropColumn('lifespan_experiment', 'tissue_specificity');
        $this->dropColumn('lifespan_experiment', 'active_substance_daily_dose');
        $this->dropColumn('lifespan_experiment', 'active_substance_daily_doses_number');   
        $this->dropColumn('lifespan_experiment', 'treatment_start');
        $this->dropColumn('lifespan_experiment', 'treatment_end');
        
        $this->dropTable('treatment_stage_of_development');
        $this->dropTable('experiment_treatment_period');
        $this->dropTable('active_substance_dosage_unit');
        $this->dropTable('active_substance_delivery_way');
        $this->dropTable('active_substance');
        $this->dropTable('gene_intervention_method');
        $this->dropTable('gene_intervention_way');
        $this->dropTable('experiment_main_effect');
        $this->dropTable('treatment_time_unit');
        $this->dropTable('lifespan_experiment_to_tissue');
        $this->dropTable('organism_sex');
        $this->dropTable('statistical_significance');
        $this->dropTable('lifespan_experiment_to_intervention_way');
        $this->dropTable('general_lifespan_experiment_to_strain');
        $this->dropTable('general_lifespan_experiment');
    }

    private function insertData()
    {
        $this->batchInsert('statistical_significance', ['id', 'name_en', 'name_ru'], [
            [1, 'yes', 'да'],
            [2, 'no', 'нет'],
            [3, 'not measured', 'не измеряли'],
        ]);
        $this->batchInsert('experiment_main_effect', ['id', 'name_en', 'name_ru'], [
            [1, 'gain of function', 'усиление функции'],
            [2, 'loss of function', 'ослабление функции'],
            [3, 'switch of function', 'переключение функции'],
        ]);
        $this->batchInsert('gene_intervention_way', ['id', 'name_en', 'name_ru'], [
            [1, 'transgenic animals creation', 'создание трансгенных животных'],
            [2, 'genetic interventions on normal animals', 'воздействие на ген у нормальных животных'],
            [3, 'combined', 'комбинированный'],
        ]);
        $this->batchInsert('treatment_time_unit', ['id', 'name_en', 'name_ru'], [
            [1, 'days', 'дней'],
            [2, 'months', 'месяцев'],
            [3, 'years', 'лет'],
            [4, 'weeks', 'недель'],
        ]);
        $this->batchInsert('treatment_stage_of_development', ['id', 'name_en', 'name_ru'], [
            [1, 'after the zygote formation', 'после образования зиготы'],
            [2, 'after birth', 'после рождения'],
            [3, 'after hatching', 'после вылупления из яйца'],
            [4, 'after hatching from the adult pupa', 'после вылупления из куколки имаго'],
        ]);

        $this->batchInsert('experiment_treatment_period', ['id', 'name_en', 'name_ru'], [
            [1, 'once', 'однократное'],
            [2, 'multiple times within a certain period', 'многократное в течение определенного периода'],
            [3, 'from a certain period until death [natural or artificial]', 'с определенного периода до смерти [естественной или искусственной]'],
        ]);

        $this->batchInsert('organism_sex', ['id', 'name_en', 'name_ru'], [
            [4, 'female', 'женский'],
            [1, 'male', 'мужской'],
            [2, 'not specified', 'не указан'],
            [3, 'mixed', 'смешанная выборка'],
        ]);

        $this->execute('update organism_sex set id=0 where id=4'); // batch insert can't insert 0 as id

        $this->execute('insert into gene_intervention_method (id, name_ru, name_en) select id, name_ru, name_en FROM gene_intervention');

        $this->execute('insert into general_lifespan_experiment (
             id, organism_sex_id, organism_line_id, model_organism_id, age, age_unit, reference, pmid, 
             comment_en, comment_ru, intervention_result_id, lifespan_change_percent_male, lifespan_change_percent_female, lifespan_change_percent_common
             ) select id, sex, organism_line_id, model_organism_id, age, age_unit, reference, pmid, 
              comment_en, comment_ru, intervention_result_id, lifespan_change_percent_male, lifespan_change_percent_female, lifespan_change_percent_common FROM lifespan_experiment');
        $this->execute('update lifespan_experiment set general_lifespan_experiment_id = id'); // every lifespan experiment should be linked to common

        $this->batchInsert('gene_intervention_method', ['name_en', 'name_ru', 'gene_intervention_way_id'], [
            ['extra copies in genome', 'дополнительные копии в геноме', 1],
            ['interfering RNAs in genome', 'интерферирующие РНК в геноме', 1],
            ['gene modification to affect gene expression', 'модификация гена, влияющая на экспрессию гена', 1],
            ['gene modification to affect product activity', 'модификация гена, влияющая на активность продукта', 1],
            ['introduction into the genome of a construct under the control of a gene promoter, which causes death or a decrease in the viability of cells expressing the gene', 'внесение в геном конструкции под контролем промотора гена, которая вызывает гибель или снижение жизнеспособности клеток, экспрессирующих ген', 1],
            ['introduction into the genome of a construct encoding elements of the CRISPR/CAS system to change the level of gene expression', 'внесение в геном конструкции, кодирующей элементы системы CRISPR/CAS, для изменения уровня экспрессии гена', 1],
            ['mRNA', 'мРНК', 2],
            ['interfering RNA vector', 'вектор с интерферирующими РНК', 2],
            ['genetic vector with a construct under the control of a gene promoter that causes death or reduced viability of cells expressing the gene', 'генетический вектор с конструкцией, находящейся под контролем промотора гена, которая вызывает гибель или снижение жизнеспособности клеток, экспрессирующих ген', 2],
            ['genetic vector encoding elements of the CRISPR/CAS system', 'генетический вектор, кодирующий элементы системы CRISPR/CAS', 2],
            ['gene expression modifier substance', 'вещество, изменяющее экспрессию гена', 2],
            ['substance for altering the activity of a protein', 'вещество, изменяющее активность белка', 2],
            ['substance for competitively interfering with the interaction of a protein with its partner', 'вещество, конкурентно мешающее взаимодействию белка с его партнером', 2],
            ['latent genetic modification + substance-inducer of latent genetic modification', 'латентная генетическая модификация + вещество-индуктор латентной генетической модификации', 3],
        ]);
        $this->execute('update lifespan_experiment set gene_intervention_method_id = gene_intervention_id');
        $this->execute('update lifespan_experiment set treatment_start_time_unit_id = age_unit');
        $this->execute('update lifespan_experiment set treatment_start = age');
        $this->execute('update lifespan_experiment set type = "experiment"');
        
        $this->update('lifespan_experiment', ['experiment_main_effect_id' => 1], 'gene_intervention_method_id in (3, 4, 5, 8, 11, 19, 20, 21)');
        $this->update('lifespan_experiment', ['experiment_main_effect_id' => 2], 'gene_intervention_method_id in (1, 2, 7, 9, 14, 16, 17, 18, 22)');
        $this->update('lifespan_experiment', ['tissue_specificity' => 1], 'gene_intervention_method_id in (21, 22)');

        $this->update('gene_intervention_method', ['gene_intervention_way_id' => 1], 'id in (4, 19, 21, 1, 17, 18, 22)');
        $this->update('gene_intervention_method', ['gene_intervention_way_id' => 2], 'id in (3, 5, 8, 9, 11, 20, 2, 7, 14, 16)');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210824_150807_extend_lifispan_experiments_form cannot be reverted.\n";

        return false;
    }
    */
}
