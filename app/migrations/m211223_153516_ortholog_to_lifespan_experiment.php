<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m211223_153516_ortholog_to_lifespan_experiment
 */
class m211223_153516_ortholog_to_lifespan_experiment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('lifespan_experiment', 'ortholog_id', Schema::TYPE_INTEGER . ' AFTER id');
        $this->addForeignKey('lifespan_experiment_to_ortholog', 'lifespan_experiment', 'ortholog_id', 'orthologs', 'id', 'CASCADE');
        $sql = 'UPDATE lifespan_experiment le
                JOIN gene_to_orthologs gto ON le.gene_id = gto.gene_id
                JOIN orthologs o ON gto.ortholog_id = o.id
                SET le.ortholog_id = o.id
                WHERE le.model_organism_id = o.model_organism_id';
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('lifespan_experiment_to_ortholog', 'lifespan_experiment');
        $this->dropColumn('lifespan_experiment', 'ortholog_id');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211223_153516_ortholog_to_lifespan_experiment cannot be reverted.\n";

        return false;
    }
    */
}
