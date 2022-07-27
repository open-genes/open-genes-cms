<?php

use yii\db\Migration;

/**
 * Class m220727_132130_create_table_confidence_level
 */
class m220727_132130_create_table_confidence_level extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%confidence_level}}', [
            'id' => $this->primaryKey(),
            'name_ru' => $this->string(255)->null(),
            'name_en' => $this->string(255)->null()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%confidence_level}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220727_132130_create_table_confidence_level cannot be reverted.\n";

        return false;
    }
    */
}
