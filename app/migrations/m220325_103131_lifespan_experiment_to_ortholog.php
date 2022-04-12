<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m220325_103131_lifespan_experiment_to_ortholog
 */
class m220325_103131_lifespan_experiment_to_ortholog extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('lifespan_experiment_to_ortholog', [
            'id' => Schema::TYPE_PK,
            'lifespan_experiment_id' => Schema::TYPE_INTEGER,
            'ortholog_id' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->addForeignKey('le_to_ortholog_to_le', 'lifespan_experiment_to_ortholog', 'lifespan_experiment_id', 'lifespan_experiment', 'id', 'CASCADE');
        $this->addForeignKey('le_to_ortholog_to_ortholog', 'lifespan_experiment_to_ortholog', 'ortholog_id', 'ortholog', 'id', 'CASCADE');

        Yii::$app->db->createCommand(
            'INSERT INTO lifespan_experiment_to_ortholog (lifespan_experiment_id, ortholog_id)
                    SELECT le.id, o.id FROM lifespan_experiment le
                    JOIN general_lifespan_experiment gle ON le.general_lifespan_experiment_id = gle.id
                    JOIN ortholog o ON gle.model_organism_id=o.model_organism_id
                    JOIN gene_to_ortholog gto ON o.id = gto.ortholog_id
                    WHERE le.gene_id = gto.gene_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('le_to_ortholog_to_le', 'lifespan_experiment_to_ortholog');
        $this->dropForeignKey('le_to_ortholog_to_ortholog', 'lifespan_experiment_to_ortholog');
        $this->dropTable('lifespan_experiment_to_ortholog');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220325_103131_lifespan_experiment_to_ortholog cannot be reverted.\n";

        return false;
    }
    */
}
