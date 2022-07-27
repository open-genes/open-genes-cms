<?php

use yii\db\Migration;

/**
 * Class m220727_131908_add_p_value_to_gene_to_longevity_effect
 */
class m220727_131908_add_p_value_to_gene_to_longevity_effect extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('gene_to_longevity_effect', 'p_value', $this->string(255)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('gene_to_longevity_effect', 'p_value');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220727_131908_add_p_value_to_gene_to_longevity_effect cannot be reverted.\n";

        return false;
    }
    */
}
