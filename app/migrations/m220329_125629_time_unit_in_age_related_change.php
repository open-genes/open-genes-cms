<?php

use yii\db\Migration;

/**
 * Class m220329_125629_time_unit_in_age_related_change
 */
class m220329_125629_time_unit_in_age_related_change extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('age_related_change', 'age_unit', 'age_unit_id');
        $this->alterColumn('age_related_change', 'age_unit_id', \yii\db\Schema::TYPE_INTEGER);
        $this->addForeignKey('age_related_change_age_unit_id', 'age_related_change', 'age_unit_id', 'time_unit', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('age_related_change_age_unit_id', 'age_related_change');
        $this->alterColumn('age_related_change', 'age_unit_id', \yii\db\Schema::TYPE_TINYINT);
        $this->renameColumn('age_related_change', 'age_unit_id', 'age_unit');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220329_125629_time_unit_in_age_related_change cannot be reverted.\n";

        return false;
    }
    */
}
