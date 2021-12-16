<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m211206_124522_add_diet
 */
class m211206_124522_add_diet extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('diet', [
            'id' => Schema::TYPE_PK,
            'name_en' => Schema::TYPE_STRING,
            'name_ru' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->addColumn('general_lifespan_experiment', 'diet_id', Schema::TYPE_INTEGER . ' DEFAULT NULL');
        $this->addForeignKey('general_lifespan_experiment_to_diet', 'general_lifespan_experiment', 'diet_id', 'diet', 'id','CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('general_lifespan_experiment_to_diet', 'general_lifespan_experiment');
        $this->dropColumn('general_lifespan_experiment', 'diet_id');
        $this->dropTable('diet');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211206_124522_add_diet cannot be reverted.\n";

        return false;
    }
    */
}
