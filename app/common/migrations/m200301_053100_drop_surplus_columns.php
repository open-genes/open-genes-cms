<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m200301_053100_drop_surplus_columns
 */
class m200301_053100_drop_surplus_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('gene', 'agePhylo');
        $this->dropColumn('gene', 'ageMya');
        $this->dropColumn('gene', 'functionalClusters');
        $this->dropColumn('gene', 'dateAdded');
        $this->dropColumn('gene', 'userEdited');
        $this->dropColumn('gene', 'expression');
        $this->dropColumn('gene', 'expressionEN');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('gene', 'agePhylo', Schema::TYPE_STRING);
        $this->addColumn('gene', 'ageMya', Schema::TYPE_STRING);
        $this->addColumn('gene', 'functionalClusters', Schema::TYPE_STRING);
        $this->addColumn('gene', 'dateAdded', Schema::TYPE_STRING);
        $this->addColumn('gene', 'userEdited', Schema::TYPE_STRING);
        $this->addColumn('gene', 'expression', Schema::TYPE_STRING);
        $this->addColumn('gene', 'expressionEN', Schema::TYPE_STRING);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200301_053100_drop_surplus_columns cannot be reverted.\n";

        return false;
    }
    */
}
