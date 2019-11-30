<?php

use yii\db\Migration;

/**
 * Class m191110_112207_unique_users
 */
class m191110_112207_unique_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('user_unique_username', 'user', 'username', true);
        $this->createIndex('user_unique_email', 'user', 'email', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('user_unique_username', 'user');
        $this->dropIndex('user_unique_email', 'user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191110_112207_unique_users cannot be reverted.\n";

        return false;
    }
    */
}
