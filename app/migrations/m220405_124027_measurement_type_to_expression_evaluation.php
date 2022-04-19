<?php

use yii\db\Migration;

/**
 * Class m220405_124027_measurement_type_to_expression_evaluation
 */
class m220405_124027_measurement_type_to_expression_evaluation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('calorie_restriction_experiment', 'measurement_type_id', 'expression_evaluation_by_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220405_124027_measurement_type_to_expression_evaluation cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220405_124027_measurement_type_to_expression_evaluation cannot be reverted.\n";

        return false;
    }
    */
}
