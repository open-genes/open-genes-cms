<?php

use yii\db\Migration;

/**
 * Class m210803_213422_add_methylation_horvath_field_to_gene
 */
class m210803_213422_add_methylation_horvath_field_to_gene extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('gene', 'methylation_horvath', $this->tinyInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('gene', 'methylation_horvath');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210803_213422_add_methylation_horvath_field_to_gene cannot be reverted.\n";

        return false;
    }
    */
}
