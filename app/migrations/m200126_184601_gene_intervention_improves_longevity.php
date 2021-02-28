<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m200126_184601_gene_intervention_improves_longevity
 */
class m200126_184601_gene_intervention_improves_longevity extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameTable('intervention_result', 'intervention_result_for_longevity');

        $this->createTable('intervention_result_for_vital_process', [
            'id' => Schema::TYPE_PK,
            'name_ru' => Schema::TYPE_STRING,
            'name_en' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('vital_process', [
            'id' => Schema::TYPE_PK,
            'name_ru' => Schema::TYPE_STRING,
            'name_en' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('gene_intervention_to_vital_process', [
            'id' => Schema::TYPE_PK,
            'gene_id' => Schema::TYPE_INTEGER,
            'gene_intervention_id' => Schema::TYPE_INTEGER,
            'intervention_result_for_vital_process_id' => Schema::TYPE_INTEGER,
            'vital_process_id' => Schema::TYPE_INTEGER,
            'model_organism_id' => Schema::TYPE_INTEGER,
            'organism_line_id' => Schema::TYPE_INTEGER,
            'age' => Schema::TYPE_INTEGER,
            'lifespan_change_percent' => Schema::TYPE_INTEGER,
            'sex_of_organism' => Schema::TYPE_INTEGER,
            'reference' => Schema::TYPE_STRING,
            'comment_en' => Schema::TYPE_TEXT,
            'comment_ru' => Schema::TYPE_TEXT,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->addForeignKey('interv_to_vital_pr_gene', 'gene_intervention_to_vital_process', 'gene_id', 'gene', 'id');
        $this->addForeignKey('interv_to_vital_pr_intervention', 'gene_intervention_to_vital_process', 'gene_intervention_id', 'gene_intervention', 'id');
        $this->addForeignKey('interv_to_vital_pr_interv_res', 'gene_intervention_to_vital_process', 'intervention_result_for_vital_process_id', 'intervention_result_for_vital_process', 'id');
        $this->addForeignKey('interv_to_vital_pr_vital_process', 'gene_intervention_to_vital_process', 'vital_process_id', 'vital_process', 'id');
        $this->addForeignKey('interv_to_vital_pr_model_organism', 'gene_intervention_to_vital_process', 'model_organism_id', 'model_organism', 'id');
        $this->addForeignKey('interv_to_vital_pr_organism_line', 'gene_intervention_to_vital_process', 'organism_line_id', 'organism_line', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('interv_to_vital_pr_organism_line', 'gene_intervention_to_vital_process');
        $this->dropForeignKey('interv_to_vital_pr_model_organism', 'gene_intervention_to_vital_process');
        $this->dropForeignKey('interv_to_vital_pr_vital_process', 'gene_intervention_to_vital_process');
        $this->dropForeignKey('interv_to_vital_pr_interv_res', 'gene_intervention_to_vital_process');
        $this->dropForeignKey('interv_to_vital_pr_intervention', 'gene_intervention_to_vital_process');
        $this->dropForeignKey('interv_to_vital_pr_gene', 'gene_intervention_to_vital_process');
        $this->renameTable('intervention_result_to_longevity', 'intervention_result');
        $this->dropTable('intervention_result_to_process');
        $this->dropTable('gene_intervention_to_vital_process');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200126_184601_gene_intervention_improves_longevity cannot be reverted.\n";

        return false;
    }
    */
}
