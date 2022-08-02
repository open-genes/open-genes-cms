<?php

use yii\db\Migration;

/**
 * Class m220721_231039_change_value_comment_of_age_related_change
 */
class m220721_231039_change_value_comment_of_age_related_change extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("UPDATE age_related_change SET comment_en = '' WHERE comment_en is null");
        $this->execute("UPDATE age_related_change SET comment_ru = '' WHERE comment_ru is null");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220721_231039_change_value_comment_of_age_related_change cannot be reverted.\n";

        return false;
    }
    */
}
