<?php

use yii\db\Migration;

/**
 * Class m220809_043259_change_type_significance_on_gene_to_longevity_effect
 */
class m220809_043259_change_type_significance_on_gene_to_longevity_effect extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        echo 'skip';
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220809_043259_change_type_significance_on_gene_to_longevity_effect cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220809_043259_change_type_significance_on_gene_to_longevity_effect cannot be reverted.\n";

        return false;
    }
    */
}
