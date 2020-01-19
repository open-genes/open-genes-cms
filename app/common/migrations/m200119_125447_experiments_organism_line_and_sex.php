<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m200119_125447_experiments_organism_line_and_sex
 */
class m200119_125447_experiments_organism_line_and_sex extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('lifespan_experiment', 'sex', Schema::TYPE_TINYINT);

        $this->createTable('organism_line', [
            'id' => Schema::TYPE_PK,
            'name_ru' => Schema::TYPE_STRING,
            'name_en' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->addColumn('lifespan_experiment', 'organism_line_id', Schema::TYPE_INTEGER);
        $this->addForeignKey('lifespan_experiment_organism_line', 'lifespan_experiment', 'organism_line_id', 'organism_line', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('lifespan_experiment_organism_line', 'lifespan_experiment');
        $this->dropColumn('lifespan_experiment', 'organism_line_id');
        $this->dropTable('organism_line');
        $this->dropColumn('lifespan_experiment', 'sex');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200119_125447_experiments_add_sex_of_organism cannot be reverted.\n";

        return false;
    }
    */
}
