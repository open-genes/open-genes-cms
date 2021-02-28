<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m200209_203116_changelog
 */
class m200209_203116_changelog extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('changelog', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER,
            'user_login' => Schema::TYPE_STRING,
            'object_name' => Schema::TYPE_STRING,
            'object_id' => Schema::TYPE_INTEGER,
            'diff' => Schema::TYPE_TEXT,
            'time' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('changelog');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200209_203116_changelog cannot be reverted.\n";

        return false;
    }
    */
}
