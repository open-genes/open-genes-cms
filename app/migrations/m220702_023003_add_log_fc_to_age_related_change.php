<?php

use yii\db\Migration;

/**
 * Class m220702_023003_add_log_fc_to_age_releated_change
 */
class m220702_023003_add_log_fc_to_age_related_change extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('age_related_change', 'log_fc', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('age_related_change', 'log_fc');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220702_023003_add_log_fc_to_age_releated_change cannot be reverted.\n";

        return false;
    }
    */
}
