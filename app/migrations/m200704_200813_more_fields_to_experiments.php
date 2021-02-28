<?php

use yii\db\Migration;

/**
 * Class m200704_200813_more_fields_to_experiments
 */
class m200704_200813_more_fields_to_experiments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('gene_to_longevity_effect', 'model_organism_id', \yii\db\Schema::TYPE_INTEGER);
        $this->addColumn('protein_to_gene', 'regulation_type', \yii\db\Schema::TYPE_TINYINT);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('gene_to_longevity_effect', 'model_organism_id');
        $this->dropColumn('protein_to_gene', 'regulation_type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200704_200813_more_fields_to_experiments cannot be reverted.\n";

        return false;
    }
    */
}
