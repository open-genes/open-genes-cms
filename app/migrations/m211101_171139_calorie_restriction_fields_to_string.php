<?php

use yii\db\Migration;

/**
 * Class m211101_171139_calorie_restriction_fields_to_string
 */
class m211101_171139_calorie_restriction_fields_to_string extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('calorie_restriction_experiment', 'p_val', $this->string());
        $this->alterColumn('calorie_restriction_experiment', 'age', $this->string());
        $this->alterColumn('calorie_restriction_experiment', 'experiment_number', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211101_171139_calorie_restriction_fields_to_string cannot be reverted.\n";

        return false;
    }
    */
}
