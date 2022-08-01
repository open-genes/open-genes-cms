<?php

use yii\db\Migration;

/**
 * Class m220801_134923_change_type_significance_on_gene_to_longevity_effect
 */
class m220801_134923_change_type_significance_on_gene_to_longevity_effect extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('gene_to_longevity_effect', 'significance', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('gene_to_longevity_effect','significance', $this->integer());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220801_134923_change_type_significance_on_gene_to_longevity_effect cannot be reverted.\n";

        return false;
    }
    */
}
