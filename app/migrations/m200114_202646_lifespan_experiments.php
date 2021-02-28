<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m200114_202646_lifespan_experiments
 */
class m200114_202646_lifespan_experiments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('gene_intervention', [
            'id' => Schema::TYPE_PK,
            'name_ru' => Schema::TYPE_STRING,
            'name_en' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('intervention_result', [
            'id' => Schema::TYPE_PK,
            'name_ru' => Schema::TYPE_STRING,
            'name_en' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('model_organism', [
            'id' => Schema::TYPE_PK,
            'name_ru' => Schema::TYPE_STRING,
            'name_en' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->createTable('lifespan_experiment', [
            'id' => Schema::TYPE_PK,
            'gene_id' => Schema::TYPE_INTEGER,
            'gene_intervention_id' => Schema::TYPE_INTEGER,
            'intervention_result_id' => Schema::TYPE_INTEGER,
            'model_organism_id' => Schema::TYPE_INTEGER,
            'age' => Schema::TYPE_INTEGER,
            'lifespan_change_percent' => Schema::TYPE_INTEGER,
            'sex_of_organism' => Schema::TYPE_INTEGER,
            'reference' => Schema::TYPE_STRING,
            'comment_en' => Schema::TYPE_TEXT,
            'comment_ru' => Schema::TYPE_TEXT,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->addForeignKey('lifespan_experiment_gene', 'lifespan_experiment', 'gene_id', 'gene', 'id');
        $this->addForeignKey('lifespan_experiment_model_organism', 'lifespan_experiment', 'model_organism_id', 'model_organism', 'id');
        $this->addForeignKey('lifespan_experiment_intervention_result', 'lifespan_experiment', 'intervention_result_id', 'intervention_result', 'id');
        $this->addForeignKey('lifespan_experiment_gene_intervention', 'lifespan_experiment', 'gene_intervention_id', 'gene_intervention', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('lifespan_experiment_gene', 'lifespan_experiment');
        $this->dropForeignKey('lifespan_experiment_model_organism', 'lifespan_experiment');
        $this->dropForeignKey('lifespan_experiment_intervention_result', 'lifespan_experiment');
        $this->dropForeignKey('lifespan_experiment_gene_intervention', 'lifespan_experiment');

        $this->dropTable('lifespan_experiment');
        $this->dropTable('model_organism');
        $this->dropTable('intervention_result');
        $this->dropTable('gene_intervention');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200114_202646_lifespan_experiments cannot be reverted.\n";

        return false;
    }
    */
}
