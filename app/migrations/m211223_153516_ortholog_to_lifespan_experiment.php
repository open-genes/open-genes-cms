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
