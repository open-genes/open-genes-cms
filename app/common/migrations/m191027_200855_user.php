<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m191027_200855_user
 */
class m191027_200855_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => Schema::TYPE_PK,
            'email' => Schema::TYPE_STRING,
            'username' => Schema::TYPE_STRING,
            'password_hash' => Schema::TYPE_STRING,
            'password_reset_token' => Schema::TYPE_STRING,
            'verification_token' => Schema::TYPE_STRING,
            'status' => Schema::TYPE_TINYINT,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'auth_key' => Schema::TYPE_STRING,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191027_200855_user cannot be reverted.\n";

        return false;
    }
    */
}
