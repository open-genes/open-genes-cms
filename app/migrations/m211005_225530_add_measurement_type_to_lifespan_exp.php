<?php

use yii\db\Migration;

/**
 * Class m211005_225530_add_measurement_type_to_lifespan_exp
 */
class m211005_225530_add_measurement_type_to_lifespan_exp extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('general_lifespan_experiment', 'measurement_type', $this->tinyInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('general_lifespan_experiment', 'measurement_type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211005_225530_add_measurement_type_to_lifespan_exp cannot be reverted.\n";

        return false;
    }
    */
}
