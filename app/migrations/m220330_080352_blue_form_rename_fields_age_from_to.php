<?php

use yii\db\Migration;

/**
 * Class m220330_080352_blue_form_rename_fields_age_from_to
 */
class m220330_080352_blue_form_rename_fields_age_from_to extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('age_related_change', 'age_from', 'mean_age_of_controls');
        $this->renameColumn('age_related_change', 'age_to', 'mean_age_of_experiment');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('age_related_change', 'mean_age_of_controls', 'age_from');
        $this->renameColumn('age_related_change', 'mean_age_of_experiment', 'age_to');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220330_080352_blue_form_rename_fields_age_from_to cannot be reverted.\n";

        return false;
    }
    */
}
