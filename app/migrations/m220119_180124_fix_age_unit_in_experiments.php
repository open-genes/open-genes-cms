<?php

use yii\db\Migration;

/**
 * Class m220119_180124_fix_age_unit_in_experiments
 */
class m220119_180124_fix_age_unit_in_experiments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameTable('treatment_time_unit', 'time_unit');
        $this->renameColumn('general_lifespan_experiment', 'age_unit', 'age_unit_id');
        $this->addForeignKey('general_lifespan_exp_age_unit', 'general_lifespan_experiment', 'age_unit_id', 'time_unit', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('general_lifespan_exp_age_unit', 'general_lifespan_experiment');
        $this->renameColumn('general_lifespan_experiment', 'age_unit_id', 'age_unit');
        $this->renameTable('time_unit', 'treatment_time_unit');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220119_180124_fix_age_unit_in_experiments cannot be reverted.\n";

        return false;
    }
    */
}
