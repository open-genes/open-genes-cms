<?php

use yii\db\Migration;

/**
 * Class m220803_014615_change_columns_physical_activity_and_dataset_file
 */
class m220803_014615_change_columns_physical_activity_and_dataset_file extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('physical_activity', 'sportsman', 'participants');
        $this->renameColumn('physical_activity', 'after_sport_result', 'result');
        $this->renameColumn('physical_activity', 'time_point', 'measurement_taken');
        $this->renameColumn('physical_activity', 'link', 'reference');

        $this->addColumn('physical_activity', 'duration', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('physical_activity', 'duration');

        $this->renameColumn('physical_activity', 'participants', 'sportsman');
        $this->renameColumn('physical_activity', 'result', 'after_sport_result');
        $this->renameColumn('physical_activity', 'measurement_taken', 'time_point');
        $this->renameColumn('physical_activity', 'reference', 'link');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220803_014615_change_columns_physical_activity_and_dataset_file cannot be reverted.\n";

        return false;
    }
    */
}
