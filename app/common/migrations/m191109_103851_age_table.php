<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m191109_103851_age_table
 */
class m191109_103851_age_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('age', [
            'id' => Schema::TYPE_PK,
            'name_phylo' => Schema::TYPE_STRING,
            'name_mya' => Schema::TYPE_STRING,
            'order' => Schema::TYPE_INTEGER,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->addColumn('gene', 'age_id', Schema::TYPE_INTEGER);
        $this->addForeignKey('gene_age', 'gene', 'age_id', 'age', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('gene_age', 'gene');
        $this->dropColumn('gene', 'age_id');
        $this->dropTable('age');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191109_103851_age_table cannot be reverted.\n";

        return false;
    }
    */
}
