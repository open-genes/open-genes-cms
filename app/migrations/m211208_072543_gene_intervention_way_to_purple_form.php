<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m211208_072543_gene_intervention_way_to_purple_form
 */
class m211208_072543_gene_intervention_way_to_purple_form extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('gene_intervention_method_way', 'gene_intervention_method');
        $this->addColumn('lifespan_experiment', 'gene_intervention_way_id', Schema::TYPE_INTEGER . ' DEFAULT NULL AFTER `gene_intervention_method_id`');
        $this->addForeignKey('gene_intervention_method_way', 'lifespan_experiment', 'gene_intervention_way_id', 'gene_intervention_way', 'id', 'CASCADE');

        $sql = 'UPDATE
                    lifespan_experiment le
                    JOIN gene_intervention_method gm
                    ON gm.id = le.gene_intervention_method_id
                SET le.gene_intervention_way_id = gm.gene_intervention_way_id';

        Yii::$app->db->createCommand($sql);
        $this->dropColumn('gene_intervention_method', 'gene_intervention_way_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('gene_intervention_method_way', 'lifespan_experiment');
        $this->dropColumn('lifespan_experiment', 'gene_intervention_way_id');
        $this->addForeignKey(
            'gene_intervention_method_way',
            'gene_intervention_method',
            'gene_intervention_way_id',
            'gene_intervention_way',
            'id'
        );
        $this->addColumn('gene_intervention_method', 'gene_intervention_way_id', Schema::TYPE_INTEGER);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211208_072543_gene_intervention_way_to_purple_form cannot be reverted.\n";

        return false;
    }
    */
}
