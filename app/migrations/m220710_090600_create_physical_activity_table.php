<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%physical_activity}}`.
 */
class m220710_090600_create_physical_activity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%physical_activity}}', [
            'id' => $this->primaryKey(),
            'gene_id' => $this->integer()->notNull(),
            'tissue_id' => $this->integer()->notNull(),
            'p_value' => $this->string( 255 ),
            'after_sport_result' => $this->string( 255 ),
            'measurement_method_id' => $this->integer()->notNull(),
            'expression_evaluation_id' => $this->integer()->notNull(),
            'time_point' => $this->string( 255 ),
            'training_regimen' => $this->string( 255 ),
            'model_organism_id' => $this->integer()->notNull(),
            'organism_line_id' => $this->integer(),
            'organism_sex_id' => $this->integer()->notNull(),
            'sportsman' => $this->string(),
            'age' => $this->string( 255 ),
            'age_units' => $this->string(),
            'experiment_groups_quantity' => $this->string(),
            'link' => $this->string(),
            'expression_change_log' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ]);


        // foreign keys
        $this->addForeignKey('fk_gene_id', 'physical_activity', 'gene_id',
            'gene', 'id', 'RESTRICT');
        $this->addForeignKey('fk_tissue_id', 'physical_activity', 'tissue_id',
            'sample', 'id', 'RESTRICT');
        $this->addForeignKey('fk_measurement_method_id', 'physical_activity', 'measurement_method_id',
            'measurement_method', 'id', 'RESTRICT');
        $this->addForeignKey('fk_expression_evaluation_id', 'physical_activity', 'expression_evaluation_id',
            'expression_evaluation', 'id', 'RESTRICT');
        $this->addForeignKey('fk_model_organism_id', 'physical_activity', 'model_organism_id',
            'model_organism', 'id', 'RESTRICT');
        $this->addForeignKey('fk_organism_line_id', 'physical_activity', 'organism_line_id',
            'organism_line', 'id', 'RESTRICT');
        $this->addForeignKey('fk_organism_sex_id', 'physical_activity', 'organism_sex_id',
            'organism_sex', 'id', 'RESTRICT');


        //indexes
        $this->createIndex('physical_activity_gene_id_idx', 'physical_activity', 'gene_id');
        $this->createIndex('physical_activity_tissue_id_idx', 'physical_activity', 'tissue_id');
        $this->createIndex('physical_activity_measurement_method_id_idx', 'physical_activity', 'measurement_method_id');
        $this->createIndex('physical_activity_expression_evaluation_id_idx', 'physical_activity', 'expression_evaluation_id');
        $this->createIndex('physical_activity_model_organism_id_idx', 'physical_activity', 'model_organism_id');
        $this->createIndex('physical_activity_organism_line_id_idx', 'physical_activity', 'organism_line_id');
        $this->createIndex('physical_activity_organism_sex_id_idx', 'physical_activity', 'organism_sex_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        $this->dropForeignKey('fk_gene_id', 'physical_activity');
        $this->dropTable('{{%physical_activity}}');
    }
}
