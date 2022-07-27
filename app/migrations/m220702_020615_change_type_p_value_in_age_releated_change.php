<?php

use yii\db\Migration;

/**
 * Class m220702_020615_change_type_p_value_in_age_releated_change
 */
class m220702_020615_change_type_p_value_in_age_releated_change extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('age_related_change', 'p_value', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('age_related_change','p_value', $this->integer());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220702_020615_change_type_p_value_in_age_releated_change cannot be reverted.\n";

        return false;
    }
    */
}
